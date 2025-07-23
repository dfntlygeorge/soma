<?php

namespace App\Http\Controllers;

use App\Helpers\ChartHelper;
use App\Helpers\MealHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MealHistoryController extends Controller
{
    //

    public function index(Request $request)
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
}