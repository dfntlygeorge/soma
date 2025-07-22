<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{

    // Show dashboard page

    public function index(): View
    {

        $user = auth()->user();
        $meals = $user->meals()->whereDate('date', Carbon::today())->get();
        $saved_meals = $user->saved_meals();
        $streak = $user->streak;
        $longest_streak = $user->longest_streak;

        $total_calories = $meals->sum('total_calories');
        $total_protein = $meals->sum('protein');
        $total_carbs = $meals->sum('carbs');
        $total_fat = $meals->sum('fat');
        $daily_macros_target = [
            [
                'label' => 'Calories',
                'daily_target' => $user->daily_calorie_target,
                'unit' => 'kcal',
                'left' => $user->daily_calorie_target - $total_calories,
            ],
            [
                'label' => 'Protein',
                'daily_target' => $user->daily_protein_target,
                'unit' => 'g',
                'left' => $user->daily_protein_target - $total_protein,
            ],
            [
                'label' => 'Carbs',
                'daily_target' => $user->daily_carbs_target,
                'unit' => 'g',
                'left' => $user->daily_carbs_target - $total_carbs,
            ],
            [
                'label' => 'Fat',
                'daily_target' => $user->daily_fat_target,
                'unit' => 'g',
                'left' => $user->daily_fat_target - $total_fat,
            ],
        ];

        $milestones = [
            3 => ['label' => '3d', 'emoji' => '🥉'],
            5 => ['label' => '5d', 'emoji' => '🥉'],
            7 => ['label' => '7d', 'emoji' => '🥈'],
            14 => ['label' => '14d', 'emoji' => '🥈'],
            30 => ['label' => '30d', 'emoji' => '🥇'],
            60 => ['label' => '60d', 'emoji' => '🥇'],
            100 => ['label' => '100d', 'emoji' => '🏆'],
        ];

        $earned = $user->earned_badges ?? [];

        $nextMilestone = null;
        $milestoneProgress = 0;

        foreach (array_keys($milestones) as $milestone) {
            $badgeKey = "{$milestone}_day";
            if (!in_array($badgeKey, $earned)) {
                $nextMilestone = $milestone;
                $milestoneProgress = min(100, ($streak / $milestone) * 100);
                break;
            }
        }


        return view("dashboard.index", compact(
            'user',
            'daily_macros_target',
            'meals',
            'saved_meals',
            'streak',
            'longest_streak',
            'milestones',
            'earned',
            'nextMilestone',
            'milestoneProgress'
        ));
    }
}
