<?php

namespace App\Services;

use Carbon\Carbon;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;
use App\Helpers\MealHelper; // Add this import

class ChartService
{
    public function weeklyCaloriesChart($meals)
    {
        // Get current week's meals (Monday to Sunday)
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $weeklyMeals = auth()->user()->meals()
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->orderBy('date')
            ->get();

        // Get daily calories and proteins data with 0s for missing dates
        $dailyCalories = MealHelper::getDailyCaloriesForRange($weeklyMeals, $startOfWeek, $endOfWeek);
        $dailyProteins = MealHelper::getDailyProteinsForRange($weeklyMeals, $startOfWeek, $endOfWeek); // Updated method name

        // Prepare chart data
        $labels = [];
        $caloriesData = [];
        $proteinsData = [];

        foreach ($dailyCalories as $date => $calories) {
            $labels[] = Carbon::parse($date)->format('M j'); // e.g., "Jul 13"
            $caloriesData[] = $calories;
            $proteinsData[] = $dailyProteins[$date] ?? 0; // Get protein for same date
        }

        // Create the chart with two datasets
        $chart = Chartjs::build()
            ->name('weeklyCaloriesChart')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels($labels)
            ->datasets([
                [
                    "label" => "Daily Calories",
                    'backgroundColor' => "rgba(148, 152, 74, 0.1)", // olive-500 with transparency
                    'borderColor' => "#94984a", // olive-500
                    "pointBorderColor" => "#94984a",
                    "pointBackgroundColor" => "#94984a",
                    "pointHoverBackgroundColor" => "#aab069", // olive-400
                    "pointHoverBorderColor" => "#767a39", // olive-600
                    "data" => $caloriesData,
                    "fill" => false,
                    "tension" => 0.4 // smooth curves
                ],
                [
                    "label" => "Daily Protein (g)",
                    'backgroundColor' => "rgba(59, 130, 246, 0.1)", // blue-500 with transparency
                    'borderColor' => "#3b82f6", // blue-500
                    "pointBorderColor" => "#3b82f6",
                    "pointBackgroundColor" => "#3b82f6",
                    "pointHoverBackgroundColor" => "#60a5fa", // blue-400
                    "pointHoverBorderColor" => "#2563eb", // blue-600
                    "data" => $proteinsData,
                    "fill" => false, // No fill for protein line
                    "tension" => 0.4
                ]
            ])
            ->options([
                'responsive' => true,
                'maintainAspectRatio' => false,
                'interaction' => [
                    'mode' => 'index',
                    'intersect' => false,
                ],
                'plugins' => [
                    'legend' => [
                        'display' => true,
                        'position' => 'top',
                        'labels' => [
                            'color' => '#9CA3AF',
                            'usePointStyle' => true,
                            'padding' => 20
                        ]
                    ]
                ],
                'scales' => [
                    'x' => [
                        'grid' => [
                            'display' => false
                        ],
                        'ticks' => [
                            'color' => '#9CA3AF' // gray-400
                        ]
                    ],
                    'y' => [
                        'grid' => [
                            'color' => '#374151' // gray-700
                        ],
                        'ticks' => [
                            'color' => '#9CA3AF' // gray-400
                        ]
                    ]
                ]
            ]);

        return $chart;
    }
}
