<?php

namespace App\Http\Controllers;

use App\Helpers\MealHelper;
use App\Helpers\StreakHelper;
use App\Models\Meal;
use App\Models\SavedMeal;
use App\Services\GeminiService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ChartService;

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

        StreakHelper::updateUserStreak($user);

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


    public function history(ChartService $chartService, Request $request)
    {
        // Get days parameter from URL (default 3, max 14)
        $days = min((int) $request->get('days', 3), 14);

        // Get user's meals
        $meals = auth()->user()->meals()->get();

        // Calculate daily averages using helper function, calculate averages of the meals within a week.
        $averages = MealHelper::calculateDailyAverages($meals);

        // Get chart data
        $chart = $chartService->weeklyCaloriesChart();

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
