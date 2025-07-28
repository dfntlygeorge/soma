<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\CuttingProgress;
use App\Models\User;
use App\Models\WeightLog;

class WeightTrackerHelper
{
    /**
     * Calculate all tracking metrics from a CuttingProgress instance.
     */
    public static function calculateMetrics(CuttingProgress $progress): array
    {
        $durationDays = $progress->duration_days;
        $startWeight = $progress->start_weight;
        $goalWeight = $progress->goal_weight;
        $currentWeight = $progress->current_weight ?? $startWeight;

        $startDate = Carbon::parse($progress->started_at)->startOfDay();
        $today = Carbon::now()->startOfDay();
        $endDate = $startDate->copy()->addDays($durationDays - 1);

        $currentDay = min($startDate->diffInDays($today) + 1, $durationDays);
        $daysLeft = max(0, $durationDays - $currentDay);

        $totalWeightToLose = $startWeight - $goalWeight;
        $weightLost = $startWeight - $currentWeight;
        $weightRemaining = $currentWeight - $goalWeight;

        $weightProgressPercent = $totalWeightToLose > 0
            ? min(100, ($weightLost / $totalWeightToLose) * 100)
            : 0;

        $timeProgressPercent = ($currentDay / $durationDays) * 100;

        $weeksLeft = $daysLeft / 7;
        $rateNeeded = $weeksLeft > 0 ? $weightRemaining / $weeksLeft : 0;

        return [
            'durationDays' => $durationDays,
            'startWeight' => $startWeight,
            'goalWeight' => $goalWeight,
            'currentWeight' => $currentWeight,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentDay' => $currentDay,
            'daysLeft' => $daysLeft,
            'totalWeightToLose' => $totalWeightToLose,
            'weightLost' => $weightLost,
            'weightRemaining' => $weightRemaining,
            'weightProgressPercent' => $weightProgressPercent,
            'timeProgressPercent' => $timeProgressPercent,
            'rateNeeded' => $rateNeeded,
        ];
    }


    // Add this method to your existing WeightTrackerHelper class

    public static function processMilestones($milestonesJson, $metrics)
    {
        $existingMilestones = json_decode($milestonesJson, true) ?? [];
        $totalWeightToLose = $metrics['totalWeightToLose'];
        $weightLost = $metrics['weightLost'];

        // Generate all possible milestones (1kg increments up to total weight to lose)
        $allMilestones = [];
        $milestoneIcons = ['🏆', '💪', '🔥', '⚡', '🎯', '🚀', '💎', '🌟', '⭐', '✨', '🎖️', '🥇', '🏅', '💫'];

        for ($i = 1; $i <= ceil($totalWeightToLose); $i++) {
            // Find existing milestone data for this amount
            $existingMilestone = collect($existingMilestones)->firstWhere('amount', $i);

            $milestone = [
                'amount' => $i,
                'label' => $i . 'kg Lost',
                'icon' => $existingMilestone['icon'] ?? $milestoneIcons[($i - 1) % count($milestoneIcons)],
                'achieved_at' => $existingMilestone['achieved_at'] ?? null,
                'status' => 'locked', // default status
                'display_date' => 'Locked'
            ];

            // Determine status based on weight lost and achieved_at
            if ($milestone['achieved_at']) {
                $milestone['status'] = 'achieved';
                $milestone['display_date'] = self::formatMilestoneDate($milestone['achieved_at']);
            } elseif ($weightLost >= $i) {
                // User has lost enough weight but milestone not recorded yet
                $milestone['status'] = 'achieved';
                $milestone['display_date'] = 'Achieved';
            } elseif ($weightLost >= ($i - 1) && $weightLost < $i) {
                // This is the next milestone to achieve
                $milestone['status'] = 'next';
                $milestone['display_date'] = 'Soon!';
            }

            $allMilestones[] = $milestone;
        }

        // Add goal reached milestone
        $goalMilestone = [
            'amount' => ceil($totalWeightToLose),
            'label' => 'Goal Reached',
            'icon' => '👑',
            'achieved_at' => null,
            'status' => $weightLost >= $totalWeightToLose ? 'achieved' : 'locked',
            'display_date' => $weightLost >= $totalWeightToLose ? 'Completed!' : 'Final Boss'
        ];

        // Check if goal is achieved
        $existingGoal = collect($existingMilestones)->firstWhere('label', 'Goal Reached');
        if ($existingGoal && $existingGoal['achieved_at']) {
            $goalMilestone['achieved_at'] = $existingGoal['achieved_at'];
            $goalMilestone['display_date'] = self::formatMilestoneDate($existingGoal['achieved_at']);
        }

        $allMilestones[] = $goalMilestone;

        return $allMilestones;
    }

    private static function formatMilestoneDate($date)
    {
        try {
            return Carbon::parse($date)->format('M j');
        } catch (\Exception $e) {
            return 'Achieved';
        }
    }

    public static function getStatsData($userId, $metrics)
    {
        $latestLog = WeightLog::getLatestForUser($userId);
        $user = User::find($userId);

        // Current Weight Stats
        $currentWeightStats = [
            'weight' => $latestLog ? $latestLog->weight : $metrics['currentWeight'],
            'total_lost' => $latestLog ? $latestLog->total_lost : $metrics['weightLost'],
            'last_logged' => $latestLog ? $latestLog->date->format('M j, Y') : 'No logs yet'
        ];

        // Goal Weight Stats
        $goalWeightStats = [
            'goal_weight' => $metrics['goalWeight'],
            'weight_remaining' => $metrics['weightRemaining'],
            'estimated_weeks' => self::calculateEstimatedWeeks($userId, $metrics, $user->calorie_deficit ?? 500)
        ];

        // Next Week Prediction
        $prediction = self::calculateNextWeekPrediction($userId, $user->calorie_deficit ?? 500);

        return [
            'current_weight' => $currentWeightStats,
            'goal_weight' => $goalWeightStats,
            'prediction' => $prediction
        ];
    }

    private static function calculateEstimatedWeeks($userId, $metrics, $calorieDeficit)
    {
        $weightRemaining = $metrics['weightRemaining'];

        if ($weightRemaining <= 0) {
            return 'Goal achieved!';
        }

        // Get recent weight loss trend (last 2-4 weeks)
        $recentLogs = WeightLog::forUser($userId)
            ->where('date', '>=', Carbon::now()->subWeeks(4))
            ->orderBy('date', 'asc')
            ->get();

        if ($recentLogs->count() >= 7) {
            // Calculate actual weekly loss rate
            $firstLog = $recentLogs->first();
            $lastLog = $recentLogs->last();
            $daysDiff = $firstLog->date->diffInDays($lastLog->date);
            $weightDiff = $firstLog->weight - $lastLog->weight;

            if ($daysDiff > 0) {
                $weeklyLossRate = ($weightDiff / $daysDiff) * 7;
                if ($weeklyLossRate > 0) {
                    $estimatedWeeks = ceil($weightRemaining / $weeklyLossRate);
                    return $estimatedWeeks . ' week' . ($estimatedWeeks !== 1 ? 's' : '');
                }
            }
        }

        // Fallback to calorie deficit calculation
        // 1kg = ~7700 calories, so weekly loss = (calorie_deficit * 7) / 7700
        $weeklyLossFromDeficit = ($calorieDeficit * 7) / 7700;
        $estimatedWeeks = ceil($weightRemaining / $weeklyLossFromDeficit);

        return $estimatedWeeks . ' week' . ($estimatedWeeks !== 1 ? 's' : '');
    }

    private static function calculateNextWeekPrediction($userId, $calorieDeficit)
    {
        $latestLog = WeightLog::getLatestForUser($userId);
        $currentWeight = $latestLog ? $latestLog->weight : 70; // fallback

        // Fetch recent logs (up to 2 weeks back, minimum 2 entries)
        $recentLogs = WeightLog::forUser($userId)
            ->where('date', '>=', Carbon::now()->subWeeks(2))
            ->orderBy('date', 'asc')
            ->get();

        $predictedLoss = null;

        if ($recentLogs->count() >= 2) {
            $firstLog = $recentLogs->first();
            $lastLog = $recentLogs->last();
            $daysDiff = $firstLog->date->diffInDays($lastLog->date);

            if ($daysDiff >= 3) { // require some reasonable time window
                $trendLoss = (($firstLog->weight - $lastLog->weight) / $daysDiff) * 7;

                // If it's realistic, use the trend
                if ($trendLoss > 0 && $trendLoss <= 1.5) {
                    $predictedLoss = $trendLoss;
                }
            }
        }

        // Fallback to calorie deficit if trend not usable
        if ($predictedLoss === null) {
            $predictedLoss = ($calorieDeficit * 7) / 7700;
        }

        $nextWeekWeight = $currentWeight - $predictedLoss;

        $nextWeekStart = Carbon::now()->addWeek()->startOfWeek();
        $nextWeekEnd = Carbon::now()->addWeek()->endOfWeek();

        return [
            'predicted_weight' => round($nextWeekWeight, 1),
            'predicted_loss' => round($predictedLoss, 1),
            'week_range' => $nextWeekStart->format('M j') . ' - ' . $nextWeekEnd->format('M j'),
            'calorie_deficit' => $calorieDeficit,
        ];
    }

    /**
     * Format weight logs data for table display
     */
    public static function formatWeightLogsForTable($weightLogs)
    {
        return $weightLogs->map(function ($log) {
            return [
                'id' => $log->id,
                'date' => Carbon::parse($log->date)->format('M j, Y'),
                'weight' => number_format($log->weight, 1) . ' kg',
                'change' => $log->change ? self::formatChange($log->change) : null,
                'total_lost' => number_format($log->total_lost, 1) . ' kg',
                'notes' => $log->notes,
                'raw_date' => $log->date,
                'raw_weight' => $log->weight,
                'raw_change' => $log->change,
                'raw_total_lost' => $log->total_lost
            ];
        });
    }

    /**
     * Format weight change with proper styling classes
     */
    private static function formatChange($change)
    {
        $formattedChange = ($change > 0 ? '+' : '') . number_format($change, 1) . ' kg';
        $colorClass = $change > 0 ? 'text-red-400' : 'text-green-400';

        return [
            'value' => $formattedChange,
            'class' => $colorClass
        ];
    }
}
