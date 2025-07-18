<?php

namespace App\Helpers;

use Carbon\Carbon;

class MealHelper
{
    /**
     * Group meals by date and return daily sums
     *
     * @param \Illuminate\Support\Collection $meals
     * @return \Illuminate\Support\Collection
     */
    public static function getDailySums($meals)
    {
        if ($meals->isEmpty()) {
            return collect();
        }

        // Group meals by date
        $groupedByDate = $meals->groupBy(function ($meal) {
            return $meal->date instanceof Carbon ? $meal->date->format('Y-m-d') : $meal->date;
        });

        // Sum calories and protein per day
        return $groupedByDate->map(function ($mealsForDay) {
            return [
                'calories' => $mealsForDay->sum('total_calories'),
                'protein' => $mealsForDay->sum('protein'),
                'date' => $mealsForDay->first()->date,
            ];
        });
    }

    /**
     * Calculate daily averages for calories and protein from meals collection
     *
     * @param \Illuminate\Support\Collection $meals
     * @return array
     */
    public static function calculateDailyAverages($meals)
    {
        $dailySums = self::getDailySums($meals);

        if ($dailySums->isEmpty()) {
            return [
                'averageCalories' => 0,
                'averageProtein' => 0,
                'daysWithMeals' => 0,
                'totalCalories' => 0,
                'totalProtein' => 0,
            ];
        }

        // Calculate totals and averages
        $totalCalories = $dailySums->sum('calories');
        $totalProtein = $dailySums->sum('protein');
        $daysWithMeals = $dailySums->count();

        return [
            'averageCalories' => round($totalCalories / $daysWithMeals),
            'averageProtein' => round($totalProtein / $daysWithMeals),
            'daysWithMeals' => $daysWithMeals,
            'totalCalories' => $totalCalories,
            'totalProtein' => $totalProtein,
        ];
    }

    /**
     * Get daily calories data for a specific date range, filling missing dates with 0
     *
     * @param \Illuminate\Support\Collection $meals
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return array
     */
    public static function getDailyCaloriesForRange($meals, Carbon $startDate, Carbon $endDate)
    {
        $dailySums = self::getDailySums($meals);
        $dailyCalories = [];
        $currentDate = $startDate->copy();

        // Initialize all dates in range with 0 calories
        while ($currentDate->lte($endDate)) {
            $dailyCalories[$currentDate->format('Y-m-d')] = 0;
            $currentDate->addDay();
        }

        // Add actual calories data
        foreach ($dailySums as $date => $data) {
            if (isset($dailyCalories[$date])) {
                $dailyCalories[$date] = $data['calories'];
            }
        }

        return $dailyCalories;
    }

    /**
     * Format a date range string (e.g., "July 13 - July 19")
     *
     * @param \Carbon\Carbon|null $startDate
     * @param \Carbon\Carbon|null $endDate
     * @return string
     */
    public static function formatDateRange($startDate = null, $endDate = null)
    {
        $startDate = $startDate ?? now()->startOfWeek();
        $endDate = $endDate ?? now()->endOfWeek();

        // If same month
        if ($startDate->format('F Y') === $endDate->format('F Y')) {
            return $startDate->format('F j') . ' - ' . $endDate->format('j, Y');
        }

        // If same year but different months
        if ($startDate->format('Y') === $endDate->format('Y')) {
            return $startDate->format('F j') . ' - ' . $endDate->format('F j, Y');
        }

        // Different years
        return $startDate->format('F j, Y') . ' - ' . $endDate->format('F j, Y');
    }

    /**
     * Get current week date range string
     *
     * @return string
     */
    public static function getCurrentWeekRange()
    {
        return self::formatDateRange(now()->startOfWeek(), now()->endOfWeek());
    }

    /**
     * Get total calories, protein, carbs, and fat for a specific date
     *
     * @param \Illuminate\Support\Collection $meals
     * @param \Carbon\Carbon|string|null $date
     * @return array
     */
    public static function getSumsForDate($meals, $date = null)
    {
        $date = $date ? Carbon::parse($date)->format('Y-m-d') : now()->format('Y-m-d');

        $filtered = $meals->filter(function ($meal) use ($date) {
            return Carbon::parse($meal->date)->format('Y-m-d') === $date;
        });

        return [
            'calories' => $filtered->sum('total_calories'),
            'protein' => $filtered->sum('protein'),
            'carbs' => $filtered->sum('carbs'),
            'fat' => $filtered->sum('fat'),
        ];
    }
}
