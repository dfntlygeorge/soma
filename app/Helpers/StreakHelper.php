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
}