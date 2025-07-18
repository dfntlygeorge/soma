<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OnboardingController extends Controller
{
    public function show(Request $request)
    {
        $step = $request->query("step", 1);

        // Redirect to step 1 if invalid step
        if ($step < 1 || $step > 5) {
            return redirect()->route("onboarding.show", ["step" => 1]);
        }

        return view("onboarding.step{$step}");
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
                $validated = $request->validate([
                    'daily_calorie_target' => 'required|integer|min:1000|max:5000',
                    'daily_protein_target' => 'required|integer|min:50|max:300',
                    'daily_carbs_target' => 'required|integer|min:50|max:500',
                    'daily_fat_target' => 'required|integer|min:20|max:200',
                ]);

                session()->put('onboarding.daily_calorie_target', $validated['daily_calorie_target']);
                session()->put('onboarding.daily_protein_target', $validated['daily_protein_target']);
                session()->put('onboarding.daily_carbs_target', $validated['daily_carbs_target']);
                session()->put('onboarding.daily_fat_target', $validated['daily_fat_target']);

                return redirect()->route('onboarding.show', ['step' => 5]);

            case 5:
                // Create user with all onboarding data
                $onboardingData = session()->get('onboarding', []);

                $user = auth()->user();

                if (!$user) {
                    // No logged-in user
                    abort(403, 'User not authenticated');
                }
                // You'll need to add name, email, password fields to step 1 or handle them separately
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

                // Redirect to dashboard or login
                return redirect()->route('dashboard')->with('success', 'Onboarding completed successfully!');

            default:
                return redirect()->route('onboarding.show', ['step' => 1]);
        }
    }
}
