<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;
use App\Models\User;

class StreakHelper
{
    public static function updateUserStreak(User $user): void
    {
        $today = now()->startOfDay();
        $yesterday = now()->subDay()->startOfDay();

        $alreadyLoggedToday = $user->meals()->whereDate('created_at', $today)->exists();

        if ($alreadyLoggedToday) {
            // dd("ALREADY LOGGED TODAY IS CALLED");
            return;
        }

        if ($user->last_logged_at?->toDateString() === $yesterday->toDateString()) {
            $user->streak += 1;
        } else {
            $user->streak = 1;
        }


        $user->last_logged_at = $today;

        if ($user->streak > $user->longest_streak) {
            $user->longest_streak = $user->streak;
        }

        // Handle badges
        $milestones = [3, 5, 7, 14, 30];

        $badges = $user->earned_badges ?? [];
        foreach ($milestones as $milestone) {
            $badgeKey = "{$milestone}_day";
            if ($user->streak === $milestone && !in_array($badgeKey, $badges)) {
                $badges[] = $badgeKey;
                session()->flash('badge_unlocked', $badgeKey); // Optional UI toast
            }
        }

        $user->earned_badges = $badges;
        $user->save();
    }

    public static function updateWeightMilestones(User $user): void
    {
        // Get user's active cutting progress
        $cuttingProgress = $user->cuttingProgress()->first();

        if (!$cuttingProgress) {
            return; // No cutting progress to track
        }

        // Calculate current metrics
        $metrics = WeightTrackerHelper::calculateMetrics($cuttingProgress);
        $weightLost = $metrics['weightLost'];
        $totalWeightToLose = $metrics['totalWeightToLose'];

        // Get existing milestones
        $existingMilestones = json_decode($cuttingProgress->milestones, true) ?? [];

        // Create a map of existing milestones for quick lookup
        $existingMilestonesMap = [];
        foreach ($existingMilestones as $milestone) {
            if (isset($milestone['label']) && $milestone['label'] === 'Goal Reached') {
                $existingMilestonesMap['goal'] = $milestone;
            } elseif (isset($milestone['amount'])) {
                $existingMilestonesMap[$milestone['amount']] = $milestone;
            }
        }

        $updatedMilestones = [];
        $today = now()->toDateString();

        // Process weight loss milestones (1kg increments)
        for ($i = 1; $i <= ceil($totalWeightToLose); $i++) {
            $existingMilestone = $existingMilestonesMap[$i] ?? null;

            // Check if this milestone should be achieved
            $shouldBeAchieved = $weightLost >= $i;
            $isAlreadyAchieved = $existingMilestone && isset($existingMilestone['achieved_at']);

            $milestone = [
                'amount' => $i,
                'label' => $i . 'kg Lost',
                'icon' => $existingMilestone['icon'] ?? self::getMilestoneIcon($i - 1),
                'achieved_at' => null,
                'status' => 'locked',
                'display_date' => 'Locked'
            ];

            if ($isAlreadyAchieved) {
                // Keep existing achievement data
                $milestone['achieved_at'] = $existingMilestone['achieved_at'];
                $milestone['status'] = 'achieved';
                $milestone['display_date'] = self::formatMilestoneDate($existingMilestone['achieved_at']);
            } elseif ($shouldBeAchieved) {
                // Newly achieved milestone
                $milestone['achieved_at'] = $today;
                $milestone['status'] = 'achieved';
                $milestone['display_date'] = 'Achieved';
            } elseif ($weightLost >= ($i - 1) && $weightLost < $i) {
                // Next milestone to achieve
                $milestone['status'] = 'next';
                $milestone['display_date'] = 'Soon!';
            }

            $updatedMilestones[] = $milestone;
        }

        // Process goal reached milestone
        $existingGoalMilestone = $existingMilestonesMap['goal'] ?? null;
        $goalShouldBeAchieved = $weightLost >= $totalWeightToLose;
        $goalIsAlreadyAchieved = $existingGoalMilestone && isset($existingGoalMilestone['achieved_at']);

        $goalMilestone = [
            'amount' => ceil($totalWeightToLose),
            'label' => 'Goal Reached',
            'icon' => '👑',
            'achieved_at' => null,
            'status' => 'locked',
            'display_date' => 'Final Boss'
        ];

        if ($goalIsAlreadyAchieved) {
            $goalMilestone['achieved_at'] = $existingGoalMilestone['achieved_at'];
            $goalMilestone['status'] = 'achieved';
            $goalMilestone['display_date'] = self::formatMilestoneDate($existingGoalMilestone['achieved_at']);
        } elseif ($goalShouldBeAchieved) {
            $goalMilestone['achieved_at'] = $today;
            $goalMilestone['status'] = 'achieved';
            $goalMilestone['display_date'] = 'Completed!';
        }

        $updatedMilestones[] = $goalMilestone;

        // Update the cutting progress with new milestones
        $cuttingProgress->milestones = json_encode($updatedMilestones);
        $cuttingProgress->save();
    }

    private static function getMilestoneIcon(int $index): string
    {
        $milestoneIcons = ['🏆', '💪', '🔥', '⚡', '🎯', '🚀', '💎', '🌟', '⭐', '✨', '🎖️', '🥇', '🏅', '💫'];
        return $milestoneIcons[$index % count($milestoneIcons)];
    }

    private static function formatMilestoneDate(string $date): string
    {
        return Carbon::parse($date)->format('M j');
    }
}
