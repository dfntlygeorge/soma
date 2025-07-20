<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\MacroRecommendationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class OnboardingController extends Controller
{
    private MacroRecommendationService $macroRecommendationService;

    public function __construct(MacroRecommendationService $macroRecommendationService)
    {
        $this->macroRecommendationService = $macroRecommendationService;
    }

    public function show(Request $request)
    {
        $user = auth()->user();
        $onboarded = $user->onboarded;
        $step = $request->query("step", 1);

        // Redirect to step 1 if invalid step
        if ($step < 1 || $step > 5) {
            return redirect()->route("onboarding.show", ["step" => 1]);
        }

        return view("onboarding.step{$step}", compact('user', 'onboarded'));
    }

    public function getRecommendations(Request $request)
    {
        try {
            // Check if we already have cached recommendations
            $cachedRecommendations = session('onboarding.macro_recommendations');

            if ($cachedRecommendations) {
                return response()->json([
                    'success' => true,
                    'data' => $cachedRecommendations
                ]);
            }

            // Get user info from session
            $userInfo = [
                'age' => session('onboarding.age'),
                'sex' => session('onboarding.sex'),
                'height' => session('onboarding.height'),
                'weight' => session('onboarding.weight'),
                'goal' => session('onboarding.goal'),
                'activity_level' => session('onboarding.activity_level'),
            ];

            // Validate that we have all required data
            foreach ($userInfo as $key => $value) {
                if (empty($value)) {
                    throw new \Exception("Missing required onboarding data: {$key}");
                }
            }

            // Get recommendations from API
            $recommendedMacros = $this->macroRecommendationService->getRecommendedMacros($userInfo);

            // Store in session for future use
            session()->put('onboarding.macro_recommendations', $recommendedMacros);

            return response()->json([
                'success' => true,
                'data' => $recommendedMacros
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to get macro recommendations: ' . $e->getMessage());

            // Return default values
            $defaultMacros = [
                'calories' => 2000,
                'protein' => 150,
                'carbs' => 200,
                'fat' => 70
            ];

            // Store defaults in session
            session()->put('onboarding.macro_recommendations', $defaultMacros);

            return response()->json([
                'success' => false,
                'data' => $defaultMacros,
                'message' => 'Unable to calculate personalized recommendations. Using default values.'
            ]);
        }
    }

    public function storeStep(Request $request)
    {
        $step = $request->input('step');

        switch ($step) {
            case 1:
                $validated = $request->validate([
                    'age' => 'required|integer|min:10|max:100',
                    'sex' => 'required|in:male,female',
                    'height' => 'required|numeric|min:50|max:300',
                    'weight' => 'required|numeric|min:20|max:500',
                ]);

                session()->put('onboarding.age', $validated['age']);
                session()->put('onboarding.sex', $validated['sex']);
                session()->put('onboarding.height', $validated['height']);
                session()->put('onboarding.weight', $validated['weight']);

                return redirect()->route('onboarding.show', ['step' => 2]);

            case 2:
                $validated = $request->validate([
                    'goal' => 'required|in:lose,maintain,gain',
                ]);

                session()->put('onboarding.goal', $validated['goal']);

                return redirect()->route('onboarding.show', ['step' => 3]);

            case 3:
                $validated = $request->validate([
                    'activity_level' => 'required|in:sedentary,light,moderate,active,extra',
                ]);

                session()->put('onboarding.activity_level', $validated['activity_level']);

                return redirect()->route('onboarding.show', ['step' => 4]);

            case 4:
                // Get macro recommendations from session
                $macroRecommendations = session('onboarding.macro_recommendations');

                if (!$macroRecommendations) {
                    // If somehow we don't have recommendations, redirect back to step 4
                    return redirect()->route('onboarding.show', ['step' => 4]);
                }

                // Store the macro targets in session
                session()->put('onboarding.daily_calorie_target', $macroRecommendations['calories']);
                session()->put('onboarding.daily_protein_target', $macroRecommendations['protein']);
                session()->put('onboarding.daily_carbs_target', $macroRecommendations['carbs']);
                session()->put('onboarding.daily_fat_target', $macroRecommendations['fat']);

                return redirect()->route('onboarding.show', ['step' => 5]);

            case 5:
                // Create user with all onboarding data
                $onboardingData = session()->get('onboarding', []);

                $user = auth()->user();

                if (!$user) {
                    // No logged-in user
                    abort(403, 'User not authenticated');
                }

                $user->update([
                    'age' => $onboardingData['age'],
                    'sex' => $onboardingData['sex'],
                    'height' => $onboardingData['height'],
                    'weight' => $onboardingData['weight'],
                    'goal' => $onboardingData['goal'],
                    'activity_level' => $onboardingData['activity_level'],
                    'daily_calorie_target' => $onboardingData['daily_calorie_target'],
                    'daily_protein_target' => $onboardingData['daily_protein_target'],
                    'daily_carbs_target' => $onboardingData['daily_carbs_target'],
                    'daily_fat_target' => $onboardingData['daily_fat_target'],
                    'onboarded' => true,
                ]);

                // Clear onboarding session data
                session()->forget('onboarding');

                // Redirect to dashboard
                return redirect()->route('dashboard')->with('success', 'Onboarding completed successfully!');

            default:
                return redirect()->route('onboarding.show', ['step' => 1]);
        }
    }
}
