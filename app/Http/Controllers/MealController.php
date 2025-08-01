<?php

namespace App\Http\Controllers;

use App\Helpers\ChartHelper;
use App\Helpers\MealHelper;
use App\Helpers\StreakHelper;
use App\Models\Meal;
use App\Models\SavedMeal;
use App\Services\GeminiService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class MealController extends Controller
{
    private GeminiService $geminiService;
    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function analyze(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:400',
        ]);

        // // Rate limiting check
        // $key = 'analyze_' . auth()->id();

        // if (RateLimiter::tooManyAttempts($key, 10)) {
        //     return redirect()->route('rate-limit-exceeded')
        //         ->with('feature', 'Meal Analysis')
        //         ->with('limit', '10 times per day');
        // }

        // // Increment the rate limiter
        // RateLimiter::hit($key, 86400); // 86400 seconds = 24 hours

        $description = $request->input('description');
        $macros = $this->geminiService->analyzeMeal($description);

        return redirect()->route('dashboard')->with(['review_macros' => $macros, 'review_description' => $description]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => 'required|string',
            'meal_type' => 'required|in:breakfast,lunch,dinner,snack',
            'total_calories' => 'required|numeric',
            'protein' => 'required|numeric',
            'carbs' => 'required|numeric',
            'fat' => 'required|numeric',
        ]);
        $user = auth()->user();
        $user_id = $user->id;
        StreakHelper::updateUserStreak($user);

        Meal::create([
            'user_id' => $user_id,
            'description' => $data['description'],
            'category' => $data['meal_type'],
            'total_calories' => $data['total_calories'],
            'protein' => $data['protein'],
            'carbs' => $data['carbs'],
            'fat' => $data['fat'],

            'date' => now(),
        ]);

        $user->increment('exp', 20);

        return redirect()->route(
            'dashboard'
        )->with('success', 'Meal logged successfully!');
    }

    public function destroy(Meal $meal)
    {
        $meal->delete();

        return redirect()->back()->with('success', 'Meal deleted successfully');
    }

    public function edit(Meal $meal)
    {
        return view("meals.edit", compact('meal'));
    }
    public function update(Request $request, Meal $meal)
    {
        $data = $request->validate([
            'description' => 'required|string|max:255',
            'total_calories' => 'required|numeric|min:0',
            'protein' => 'required|numeric|min:0',
            'carbs' => 'required|numeric|min:0',
            'fat' => 'required|numeric|min:0',
            'meal_type' => 'required|in:breakfast,lunch,dinner,snack'
        ]);

        $meal->update([
            'description' => $data['description'],
            'total_calories' => $data['total_calories'],
            'protein' => $data['protein'],
            'carbs' => $data['carbs'],
            'fat' => $data['fat'],
            'category' => $data['meal_type'], // Map meal_type to category
        ]);

        return redirect()->route('dashboard')->with('success', 'Meal edited successfully!');
    }


    public function history(Request $request)
    {
        // Get days parameter from URL (default 3, max 14)
        $days = min((int) $request->get('days', 3), 14);

        // Fetch all meals once
        $meals = auth()->user()->meals()->orderBy('date')->get();

        // Define current week's date range
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        // Filter weekly meals from the full collection
        $weeklyMeals = $meals->filter(function ($meal) use ($startOfWeek, $endOfWeek) {
            return $meal->date >= $startOfWeek && $meal->date <= $endOfWeek;
        });

        // Calculate daily averages using helper function, calculate averages of the meals within a week.
        $averages = MealHelper::calculateDailyAverages($weeklyMeals);

        // Get chart data
        $chart = ChartHelper::buildCaloriesAndProteinsChart($weeklyMeals, $startOfWeek, $endOfWeek);

        // Get formatted current week range
        $weekRange = MealHelper::getCurrentWeekRange();

        // Get daily meal data for the requested number of days
        $dailyMealData = MealHelper::getDailyMealData($meals, $days);

        // Get today's macro sums (for backwards compatibility if needed elsewhere)
        $todayMacroSums = MealHelper::getSumsForDate($meals);

        // Calculate if there are more days available to load
        $oldestMealDate = $meals->min('date');
        $canLoadMore = $days < 14 && $oldestMealDate &&
            Carbon::parse($oldestMealDate)->diffInDays(now()) >= $days;

        // Calculate next load amount (increment by 3 days)
        $nextDays = min($days + 3, 14);

        return view("meals.history", compact(
            'meals',
            'chart',
            'weekRange',
            'dailyMealData',
            'days',
            'canLoadMore',
            'nextDays'
        ) + $averages + $todayMacroSums);
    }

    public function quickAdd(SavedMeal $meal)
    {
        $user = auth()->user();

        Meal::create([
            'user_id' => $user->id,
            'description' => $meal->name,
            'category' => $meal->category,
            'total_calories' => $meal->calories,
            'protein' => $meal->protein,
            'carbs' => $meal->carbs,
            'fat' => $meal->fat,
            'date' => now(),
        ]);

        return redirect()->route(
            'dashboard'
        )->with('success', 'Meal logged successfully!');
    }
}