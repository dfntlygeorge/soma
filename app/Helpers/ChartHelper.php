<?php

namespace App\Helpers;

use Carbon\Carbon;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;
use Illuminate\Database\Eloquent\Collection;

class ChartHelper
{
    public static function buildCaloriesAndProteinsChart(Collection $meals, Carbon $startDate, Carbon $endDate)
    {
        // Get daily calories and proteins data (0s for missing dates)
        $dailyCalories = MealHelper::getDailyCaloriesForRange($meals, $startDate, $endDate);
        $dailyProteins = MealHelper::getDailyProteinsForRange($meals, $startDate, $endDate);

        // Prepare chart data
        $labels = [];
        $caloriesData = [];
        $proteinsData = [];

        foreach ($dailyCalories as $date => $calories) {
            $labels[] = Carbon::parse($date)->format('M j'); // e.g., "Jul 13"
            $caloriesData[] = $calories;
            $proteinsData[] = $dailyProteins[$date] ?? 0;
        }

        return Chartjs::build()
            ->name('caloriesProteinChart')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels($labels)
            ->datasets([
                [
                    "label" => "Daily Calories",
                    'backgroundColor' => "rgba(148, 152, 74, 0.1)",
                    'borderColor' => "#94984a",
                    "pointBorderColor" => "#94984a",
                    "pointBackgroundColor" => "#94984a",
                    "pointHoverBackgroundColor" => "#aab069",
                    "pointHoverBorderColor" => "#767a39",
                    "data" => $caloriesData,
                    "fill" => false,
                    "tension" => 0.4
                ],
                [
                    "label" => "Daily Protein (g)",
                    'backgroundColor' => "rgba(59, 130, 246, 0.1)",
                    'borderColor' => "#3b82f6",
                    "pointBorderColor" => "#3b82f6",
                    "pointBackgroundColor" => "#3b82f6",
                    "pointHoverBackgroundColor" => "#60a5fa",
                    "pointHoverBorderColor" => "#2563eb",
                    "data" => $proteinsData,
                    "fill" => false,
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
                        'grid' => ['display' => false],
                        'ticks' => ['color' => '#9CA3AF']
                    ],
                    'y' => [
                        'grid' => ['color' => '#374151'],
                        'ticks' => ['color' => '#9CA3AF']
                    ]
                ]
            ]);
    }
}
