<?php

namespace App\Http\Controllers;

use App\Helpers\DashboardHelper;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $saved_meals = $user->saved_meals();
        $streak = $user->streak;
        $longest_streak = $user->longest_streak;
        $milestones = [
            3 => ['label' => '3d', 'emoji' => '🥉'],
            5 => ['label' => '5d', 'emoji' => '🥉'],
            7 => ['label' => '7d', 'emoji' => '🥈'],
            14 => ['label' => '14d', 'emoji' => '🥈'],
            30 => ['label' => '30d', 'emoji' => '🥇'],
            60 => ['label' => '60d', 'emoji' => '🥇'],
            100 => ['label' => '100d', 'emoji' => '🏆'],
        ];

        $totals = DashboardHelper::getDailyMacroSummary($user);
        $daily_macros_target = DashboardHelper::getDailyMacroTargets($user, $totals);
        [$nextMilestone, $milestoneProgress] = DashboardHelper::getNextMilestoneData($user, $milestones);
        $rankData = DashboardHelper::getRankData($user);

        return view('dashboard.index', array_merge([
            'user' => $user,
            'daily_macros_target' => $daily_macros_target,
            'meals' => $totals['meals'],
            'saved_meals' => $saved_meals,
            'streak' => $streak,
            'longest_streak' => $longest_streak,
            'milestones' => $milestones,
            'earned' => $user->earned_badges ?? [],
            'nextMilestone' => $nextMilestone,
            'milestoneProgress' => $milestoneProgress,
        ], $rankData));
    }
}
