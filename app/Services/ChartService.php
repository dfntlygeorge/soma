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

        // Use helper to get daily calories data with 0s for missing dates
        $dailyCalories = MealHelper::getDailyCaloriesForRange($weeklyMeals, $startOfWeek, $endOfWeek);

        // Prepare chart data
        $labels = [];
        $data = [];

        foreach ($dailyCalories as $date => $calories) {
            $labels[] = Carbon::parse($date)->format('M j'); // e.g., "Jul 13"
            $data[] = $calories;
        }

        // Create the chart
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
                    "data" => $data,
                    "fill" => true,
                    "tension" => 0.4, // smooth curves
                ]
            ])
            ->options([
                'responsive' => true,
                'maintainAspectRatio' => false,
                'plugins' => [
                    'legend' => [
                        'display' => false
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
                            'color' => '#9CA3AF', // gray-400
                            'callback' => 'function(value) { return value + " cal"; }'
                        ]
                    ]
                ]
            ]);

        return $chart;
    }
}
