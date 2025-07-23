<?php

namespace App\Http\Controllers;

use App\Helpers\ChartHelper;
use App\Helpers\MealHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MealHistoryController extends Controller
{
    public function index(Request $request)
    {
        // Get days parameter from URL (default 3, max 14)
        $days = min((int) $request->get('days', 3), 14);

        // Get week offset parameter (default 0 for current week)
        $weekOffset = (int) $request->get('week', 0);

        // Fetch all meals once
        $meals = auth()->user()->meals()->orderBy('date')->get();

        // Define week's date range based on offset
        $startOfWeek = now()->addWeeks($weekOffset)->startOfWeek();
        $endOfWeek = now()->addWeeks($weekOffset)->endOfWeek();

        // Filter weekly meals from the full collection
        $weeklyMeals = $meals->filter(function ($meal) use ($startOfWeek, $endOfWeek) {
            return $meal->date >= $startOfWeek && $meal->date <= $endOfWeek;
        });

        // Calculate daily averages using helper function
        $averages = MealHelper::calculateDailyAverages($weeklyMeals);

        // Get chart data
        $chart = ChartHelper::buildCaloriesAndProteinsChart($weeklyMeals, $startOfWeek, $endOfWeek);

        // Get formatted week range
        $weekRange = MealHelper::getWeekRange($startOfWeek, $endOfWeek);

        // Navigation logic - check if there's data for previous/next weeks
        $canGoToPreviousWeek = $this->hasDataForWeek($meals, $weekOffset - 1);
        $canGoToNextWeek = $weekOffset < 0 && $this->hasDataForWeek($meals, $weekOffset + 1);

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

        // Add this temporarily in your controller after fetching meals, before the return statement
        // This will help us debug what's going wrong

        // // // // Debug current meal dates
        // $mealDates = $meals->pluck('date')->toArray();
        // dd([
        //     'weekOffset' => $weekOffset,
        //     'meal_dates' => $mealDates,
        //     'start_of_current_week' => now()->startOfWeek()->toDateString(),
        //     'end_of_current_week' => now()->endOfWeek()->toDateString(),
        //     'start_of_previous_week' => now()->addWeeks(-1)->startOfWeek()->toDateString(),
        //     'end_of_previous_week' => now()->addWeeks(-1)->endOfWeek()->toDateString(),
        //     'canGoToPreviousWeek' => $canGoToPreviousWeek,
        //     'canGoToNextWeek' => $canGoToNextWeek,
        //     'hasDataForCurrentWeek' => $this->hasDataForWeek($meals, 0),
        //     'hasDataForPreviousWeek' => $this->hasDataForWeek($meals, -1),
        // ]);

        return view("meals.history", compact(
            'meals',
            'chart',
            'weekRange',
            'dailyMealData',
            'days',
            'canLoadMore',
            'nextDays',
            'weekOffset',
            'canGoToPreviousWeek',
            'canGoToNextWeek'
        ) + $averages + $todayMacroSums);
    }

    /**
     * Check if there's meal data for a specific week offset
     */
    private function hasDataForWeek($meals, $weekOffset)
    {
        $startOfWeek = now()->addWeeks($weekOffset)->startOfWeek()->toDateString();
        $endOfWeek = now()->addWeeks($weekOffset)->endOfWeek()->toDateString();

        return $meals->filter(function ($meal) use ($startOfWeek, $endOfWeek) {
            $mealDate = is_string($meal->date) ? $meal->date : $meal->date->toDateString();
            return $mealDate >= $startOfWeek && $mealDate <= $endOfWeek;
        })->isNotEmpty();
    }
}
