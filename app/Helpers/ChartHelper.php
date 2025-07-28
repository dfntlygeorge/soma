<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\WeightLog;
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

    public static function buildWeightProgressChart($userId, $goalWeight)
    {
        // Get weight logs for the last month only
        $weightLogs = WeightLog::where('user_id', $userId)
            ->where('date', '>=', Carbon::now()->subMonth())
            ->orderBy('date', 'asc')
            ->get();

        if ($weightLogs->isEmpty()) {
            return self::buildEmptyWeightChart($goalWeight);
        }

        // Get user's daily calorie deficit (you might need to adjust this based on your user model)
        $user = User::find($userId);
        $dailyDeficit = $user->calorie_deficit ?? 500; // Default 500 cal deficit

        // Create extended timeline: actual logs + 30 days prediction
        $lastLogDate = Carbon::parse($weightLogs->last()->date);
        $endDate = $lastLogDate->copy()->addDays(30);

        $labels = [];
        $actualWeights = [];
        $goalWeights = [];
        $predictions = [];

        // Add actual logged data
        foreach ($weightLogs as $log) {
            $labels[] = Carbon::parse($log->date)->format('M j');
            $actualWeights[] = $log->weight;
            $goalWeights[] = $goalWeight;
            $predictions[] = null;
        }

        // Add future prediction dates (next 30 days)
        $currentWeight = $weightLogs->last()->weight;
        $weeklyWeightLoss = ($dailyDeficit * 7) / 7700;
        // 7700 calories = 1kg

        for ($i = 1; $i <= 30; $i++) {
            $futureDate = $lastLogDate->copy()->addDays($i);
            $labels[] = $futureDate->format('M j');
            $actualWeights[] = null; // No actual weight yet
            $goalWeights[] = $goalWeight;

            // Calculate predicted weight based on deficit
            $weeksFromNow = $i / 7;
            $predictedWeight = $currentWeight - ($weeklyWeightLoss * $weeksFromNow);
            $predictions[] = round($predictedWeight, 1);
        }

        // Calculate Y-axis range including predictions
        $allValues = array_merge(
            array_filter($actualWeights),
            array_filter($predictions),
            [$goalWeight]
        );
        $minWeight = min($allValues);
        $maxWeight = max($allValues);
        $yMin = $minWeight - 5;
        $yMax = $maxWeight + 5;

        return Chartjs::build()
            ->name('weightChart')
            ->type('line')
            ->size(['width' => 400, 'height' => 400])
            ->labels($labels)
            ->datasets([
                [
                    "label" => "Actual Weight",
                    'backgroundColor' => "rgba(59, 130, 246, 0.1)",
                    'borderColor' => "#3B82F6",
                    "data" => $actualWeights,
                    "fill" => false,
                    "tension" => 0.1,
                    "borderWidth" => 3,
                    "pointRadius" => 4,
                    "spanGaps" => false // Don't connect across gaps
                ],
                [
                    "label" => "Goal Weight",
                    'borderColor' => "#10B981",
                    "data" => $goalWeights,
                    "fill" => false,
                    "borderWidth" => 2,
                    "borderDash" => [5, 5],
                    "pointRadius" => 0,
                ],
                [
                    "label" => "Projected Weight",
                    'borderColor' => "#8B5CF6",
                    "data" => $predictions,
                    "fill" => false,
                    "borderWidth" => 2,
                    "borderDash" => [3, 3],
                    "pointRadius" => 2,
                    "spanGaps" => true, // Connect prediction line
                    "backgroundColor" => "rgba(139, 92, 246, 0.1)"
                ]
            ])
            ->options([
                'responsive' => true,
                'maintainAspectRatio' => false,
                'plugins' => [
                    'legend' => [
                        'display' => true
                    ]
                ],
                'scales' => [
                    'x' => [
                        'grid' => [
                            'color' => 'rgba(75, 85, 99, 0.3)'
                        ],
                        'ticks' => [
                            'color' => '#9CA3AF',
                            'maxRotation' => 45,
                            'maxTicksLimit' => 15 // Limit labels to prevent crowding
                        ]
                    ],
                    'y' => [
                        'grid' => [
                            'color' => 'rgba(75, 85, 99, 0.3)'
                        ],
                        'ticks' => [
                            'color' => '#9CA3AF'
                        ],
                        'min' => $yMin,
                        'max' => $yMax
                    ]
                ]
            ]);
    }

    // Alternative: Use recent trend if you prefer trend-based over deficit-based prediction
    private static function calculateTrendBasedPrediction($weightLogs, $days = 30)
    {
        if ($weightLogs->count() < 3) {
            return [];
        }

        // Get trend from last week of data
        $recentLogs = $weightLogs->slice(-7);
        $firstWeight = $recentLogs->first()->weight;
        $lastWeight = $recentLogs->last()->weight;
        $trendDays = $recentLogs->first()->date->diffInDays($recentLogs->last()->date);

        if ($trendDays == 0) return [];

        $dailyChange = ($lastWeight - $firstWeight) / $trendDays;

        $predictions = [];
        $baseWeight = $weightLogs->last()->weight;

        for ($i = 1; $i <= $days; $i++) {
            $predictions[] = round($baseWeight + ($dailyChange * $i), 1);
        }

        return $predictions;
    }

    private static function calculateSimplePrediction($weightLogs, $goalWeight)
    {
        $predictions = [];

        // Fill with nulls for existing data points
        foreach ($weightLogs as $log) {
            $predictions[] = null;
        }

        // Only add prediction if we have at least 3 data points
        if ($weightLogs->count() >= 3) {
            $recent = $weightLogs->slice(-3); // Get last 3 entries
            $firstWeight = $recent->first()->weight;
            $lastWeight = $recent->last()->weight;
            $days = $recent->first()->date->diffInDays($recent->last()->date);

            if ($days > 0) {
                $dailyChange = ($lastWeight - $firstWeight) / $days;

                // Add a simple 7-day prediction
                $lastIndex = count($predictions) - 1;
                $predictions[$lastIndex] = $lastWeight + ($dailyChange * 7);
            }
        }

        return $predictions;
    }

    private static function buildEmptyWeightChart($goalWeight)
    {
        dd("REALLY");
        $labels = ['No Data'];
        $goalWeights = [$goalWeight];

        return Chartjs::build()
            ->name('weightChart')
            ->type('line')
            ->size(['width' => 400, 'height' => 400])
            ->labels($labels)
            ->datasets([
                [
                    "label" => "Goal Weight",
                    'backgroundColor' => "rgba(16, 185, 129, 0.1)",
                    'borderColor' => "#10B981",
                    "data" => $goalWeights,
                    "borderDash" => [5, 5],
                    "pointRadius" => 0
                ]
            ])
            ->options([
                'responsive' => true,
                'maintainAspectRatio' => false,
                'plugins' => [
                    'legend' => ['display' => false]
                ],
                'scales' => [
                    'x' => [
                        'grid' => ['color' => 'rgba(75, 85, 99, 0.3)'],
                        'ticks' => ['color' => '#9CA3AF']
                    ],
                    'y' => [
                        'grid' => ['color' => 'rgba(75, 85, 99, 0.3)'],
                        'ticks' => ['color' => '#9CA3AF'],
                        'min' => $goalWeight - 2,
                        'max' => $goalWeight + 10
                    ]
                ]
            ]);
    }
}
