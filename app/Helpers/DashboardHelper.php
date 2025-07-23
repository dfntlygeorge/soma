<?php

namespace App\Helpers;

use Carbon\Carbon;

class DashboardHelper
{
    public static function getDailyMacroSummary($user)
    {
        $meals = $user->meals()->whereDate('date', Carbon::today())->get();

        return [
            'meals' => $meals,
            'total_calories' => $meals->sum('total_calories'),
            'total_protein' => $meals->sum('protein'),
            'total_carbs' => $meals->sum('carbs'),
            'total_fat' => $meals->sum('fat'),
        ];
    }

    public static function getDailyMacroTargets($user, $totals)
    {
        return [
            [
                'label' => 'Calories',
                'daily_target' => $user->daily_calorie_target,
                'unit' => 'kcal',
                'left' => $user->daily_calorie_target - $totals['total_calories'],
            ],
            [
                'label' => 'Protein',
                'daily_target' => $user->daily_protein_target,
                'unit' => 'g',
                'left' => $user->daily_protein_target - $totals['total_protein'],
            ],
            [
                'label' => 'Carbs',
                'daily_target' => $user->daily_carbs_target,
                'unit' => 'g',
                'left' => $user->daily_carbs_target - $totals['total_carbs'],
            ],
            [
                'label' => 'Fat',
                'daily_target' => $user->daily_fat_target,
                'unit' => 'g',
                'left' => $user->daily_fat_target - $totals['total_fat'],
            ],
        ];
    }

    public static function getNextMilestoneData($user, $milestones)
    {
        $earned = $user->earned_badges ?? [];
        $streak = $user->streak;

        foreach (array_keys($milestones) as $milestone) {
            $badgeKey = "{$milestone}_day";
            if (!in_array($badgeKey, $earned)) {
                return [
                    $milestone,
                    min(100, ($streak / $milestone) * 100),
                ];
            }
        }

        return [null, 0];
    }


    public static function getRankData($user)
    {
        return [
            'rankInfo' => RankHelper::getRankFromExp($user->exp),
            'rankNextInfo' => RankHelper::getNextRankInfo($user->exp),
            'rankProgressPercent' => RankHelper::getRankProgressPercent($user->exp),
        ];
    }
}
