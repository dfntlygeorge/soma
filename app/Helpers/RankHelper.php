<?php

namespace App\Helpers;

use App\Models\User;

class RankHelper
{
    public static function getRankFromExp($exp)
    {
        return match (true) {
            $exp < 100     => [
                'name' => 'Copper',
                'description' => 'Kahit basic, may charm. Gaya ng \'hi\' mo na kinilig ako agad.',
            ],
            $exp < 300     => [
                'name' => 'Bronze',
                'description' => 'Hindi pa premium, pero hindi rin pang-karaniwang landi.',
            ],
            $exp < 600     => [
                'name' => 'Silver',
                'description' => 'Pwede na sa nanay mo, pangpakilala na.',
            ],
            $exp < 1000    => [
                'name' => 'Gold',
                'description' => 'Mahal ka na ng barkada ko, pero \'di pa ako sure.',
            ],
            $exp < 1500    => [
                'name' => 'Platinum',
                'description' => 'Sobrang rare, parang ikaw lang ang consistent sa chat.',
            ],
            $exp < 2000    => [
                'name' => 'Diamond',
                'description' => 'Pag ikaw nagparamdam, kinikilig pati notifications ko.',
            ],
            $exp < 2500    => [
                'name' => 'Obsidian',
                'description' => 'Hot, mysterious, tapos biglang \'Wyd?\' at 2AM.',
            ],
            default        => [
                'name' => 'Mythril',
                'description' => 'Myth ka ba? Kasi parang ikaw ang ending ng lahat ng landi ko.',
            ],
        };
    }


    public static function getNextRankInfo($exp)
    {
        $ranks = [
            'Copper'  => 0,
            'Bronze'  => 100,
            'Silver'  => 300,
            'Gold'    => 600,
            'Platinum' => 1000,
            'Diamond' => 1500,
            'Obsidian' => 2000,
            'Mythril' => 2500, // max
        ];

        foreach ($ranks as $rank => $threshold) {
            if ($exp < $threshold) {
                return [
                    'next_rank' => $rank,
                    'exp_needed' => $threshold - $exp,
                    'next_threshold' => $threshold,
                ];
            }
        }

        // If no next rank, Mythril is max
        return [
            'next_rank' => null,
            'exp_needed' => 0,
            'next_threshold' => null,
        ];
    }
    public static function getRankProgressPercent($exp)
    {
        $thresholds = [
            'Copper'   => 0,
            'Bronze'   => 100,
            'Silver'   => 300,
            'Gold'     => 600,
            'Platinum' => 1000,
            'Diamond'  => 1500,
            'Obsidian' => 2000,
            'Mythril'  => 2500,
        ];

        $rankInfo = self::getRankFromExp($exp);
        $currentRank = $rankInfo['name'];

        $currentThreshold = $thresholds[$currentRank] ?? 0;

        $nextRankInfo = self::getNextRankInfo($exp);
        $nextThreshold = $nextRankInfo['next_threshold'];

        // Max rank case
        if ($nextThreshold === null) {
            return 100;
        }

        $earned = $exp - $currentThreshold;
        $range = $nextThreshold - $currentThreshold;
        $percent = ($range > 0) ? (int) floor(($earned / $range) * 100) : 0;

        return max(0, min($percent, 100)); // Clamp between 0–100
    }
}
