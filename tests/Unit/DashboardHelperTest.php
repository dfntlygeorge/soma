<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Meal;
use App\Helpers\DashboardHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class DashboardHelperTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_correct_macro_summary_for_today()
    {
        $user = User::factory()->create();

        // Today's meals
        Meal::factory()->create([
            'user_id' => $user->id,
            'date' => Carbon::today(),
            'total_calories' => 500,
            'protein' => 30,
            'carbs' => 50,
            'fat' => 20,
        ]);

        Meal::factory()->create([
            'user_id' => $user->id,
            'date' => Carbon::today(),
            'total_calories' => 300,
            'protein' => 20,
            'carbs' => 30,
            'fat' => 10,
        ]);

        // Old meal (should be ignored)
        Meal::factory()->create([
            'user_id' => $user->id,
            'date' => Carbon::yesterday(),
            'total_calories' => 900,
            'protein' => 50,
            'carbs' => 100,
            'fat' => 40,
        ]);

        $summary = DashboardHelper::getDailyMacroSummary($user);

        $this->assertCount(2, $summary['meals']);
        $this->assertEquals(800, $summary['total_calories']);
        $this->assertEquals(50, $summary['total_protein']);
        $this->assertEquals(80, $summary['total_carbs']);
        $this->assertEquals(30, $summary['total_fat']);
    }

    /** @test */
    public function it_returns_correct_daily_macro_targets()
    {
        $user = User::factory()->create([
            'daily_calorie_target' => 2000,
            'daily_protein_target' => 150,
            'daily_carbs_target' => 250,
            'daily_fat_target' => 70,
        ]);

        $totals = [
            'total_calories' => 800,
            'total_protein' => 60,
            'total_carbs' => 100,
            'total_fat' => 30,
        ];

        $targets = DashboardHelper::getDailyMacroTargets($user, $totals);

        $this->assertEquals([
            [
                'label' => 'Calories',
                'daily_target' => 2000,
                'unit' => 'kcal',
                'left' => 1200,
            ],
            [
                'label' => 'Protein',
                'daily_target' => 150,
                'unit' => 'g',
                'left' => 90,
            ],
            [
                'label' => 'Carbs',
                'daily_target' => 250,
                'unit' => 'g',
                'left' => 150,
            ],
            [
                'label' => 'Fat',
                'daily_target' => 70,
                'unit' => 'g',
                'left' => 40,
            ],
        ], $targets);
    }

    /** @test */
    public function it_returns_next_unearned_milestone_and_progress()
    {
        $user = User::factory()->make([
            'streak' => 4,
            'earned_badges' => ['3_day'],
        ]);

        $milestones = [
            3 => ['label' => '3d', 'emoji' => '🥉'],
            5 => ['label' => '5d', 'emoji' => '🥉'],
            10 => ['label' => '10d', 'emoji' => '🥈'],
        ];

        [$nextMilestone, $progress] = DashboardHelper::getNextMilestoneData($user, $milestones);

        $this->assertEquals(5, $nextMilestone);
        $this->assertEquals(80, $progress); // (4 / 5) * 100
    }

    /** @test */
    public function it_returns_null_and_zero_if_all_milestones_are_earned()
    {
        $user = User::factory()->make([
            'streak' => 15,
            'earned_badges' => ['3_day', '5_day', '10_day'],
        ]);

        $milestones = [
            3 => ['label' => '3d', 'emoji' => '🥉'],
            5 => ['label' => '5d', 'emoji' => '🥉'],
            10 => ['label' => '10d', 'emoji' => '🥈'],
        ];

        [$nextMilestone, $progress] = DashboardHelper::getNextMilestoneData($user, $milestones);

        $this->assertNull($nextMilestone);
        $this->assertEquals(0, $progress);
    }

    /** @test */
    public function it_caps_progress_at_100_percent()
    {
        $user = User::factory()->make([
            'streak' => 10,
            'earned_badges' => [],
        ]);

        $milestones = [
            5 => ['label' => '5d', 'emoji' => '🥉'],
        ];

        [$nextMilestone, $progress] = DashboardHelper::getNextMilestoneData($user, $milestones);

        $this->assertEquals(5, $nextMilestone);
        $this->assertEquals(100, $progress); // capped even though it's 200%
    }
}
