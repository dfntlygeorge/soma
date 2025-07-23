<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Helpers\RankHelper;

class RankHelperTest extends TestCase
{
    public function test_get_rank_from_exp()
    {
        $this->assertSame('Copper', RankHelper::getRankFromExp(0)['name']);
        $this->assertSame('Bronze', RankHelper::getRankFromExp(150)['name']);
        $this->assertSame('Silver', RankHelper::getRankFromExp(350)['name']);
        $this->assertSame('Gold', RankHelper::getRankFromExp(800)['name']);
        $this->assertSame('Platinum', RankHelper::getRankFromExp(1200)['name']);
        $this->assertSame('Diamond', RankHelper::getRankFromExp(1700)['name']);
        $this->assertSame('Obsidian', RankHelper::getRankFromExp(2100)['name']);
        $this->assertSame('Mythril', RankHelper::getRankFromExp(3000)['name']);
    }

    public function test_get_next_rank_info()
    {
        $this->assertEquals([
            'next_rank' => 'Bronze',
            'exp_needed' => 50,
            'next_threshold' => 100,
        ], RankHelper::getNextRankInfo(50));

        $this->assertEquals([
            'next_rank' => null,
            'exp_needed' => 0,
            'next_threshold' => null,
        ], RankHelper::getNextRankInfo(2600)); // Mythril max
    }

    public function test_get_rank_progress_percent()
    {
        $this->assertSame(50, RankHelper::getRankProgressPercent(50)); // Halfway to Bronze
        $this->assertSame(100, RankHelper::getRankProgressPercent(2500)); // Mythril max
        $this->assertSame(0, RankHelper::getRankProgressPercent(0)); // Starting Copper
        $this->assertSame(12, RankHelper::getRankProgressPercent(125)); // 25% of Bronze (100–300)
    }
}
