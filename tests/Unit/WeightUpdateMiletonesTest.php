<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\CuttingProgress;
use App\Helpers\StreakHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class WeightUpdateMiletonesTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $cuttingProgress;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create cutting progress with realistic data
        $this->cuttingProgress = CuttingProgress::create([
            'user_id' => $this->user->id,
            'start_weight' => 80.0,
            'goal_weight' => 70.0,
            'current_weight' => 80.0,
            'duration_days' => 90,
            'started_at' => now()->subDays(10),
            'milestones' => json_encode([])
        ]);
    }

    /** @test */
    public function it_returns_early_when_user_has_no_cutting_progress()
    {
        // Delete the cutting progress
        $this->cuttingProgress->delete();

        // Call the function
        StreakHelper::updateWeightMilestones($this->user);

        // Assert nothing happened (no exceptions thrown)
        $this->assertTrue(true);
    }

    /** @test */
    public function it_creates_initial_milestones_when_no_weight_lost()
    {
        // User hasn't lost any weight yet
        $this->cuttingProgress->update(['current_weight' => 80.0]);

        StreakHelper::updateWeightMilestones($this->user);

        $this->cuttingProgress->refresh();
        $milestones = json_decode($this->cuttingProgress->milestones, true);

        // Should have 10 milestones (1kg-10kg) + goal milestone
        $this->assertCount(11, $milestones);

        // First milestone should be "next" since it's the immediate target
        $firstMilestone = collect($milestones)->firstWhere('amount', 1);
        $this->assertEquals('next', $firstMilestone['status']);
        $this->assertEquals('Soon!', $firstMilestone['display_date']);

        // All others should be locked
        $otherMilestones = collect($milestones)->where('amount', '>', 1)->where('label', '!=', 'Goal Reached');
        foreach ($otherMilestones as $milestone) {
            $this->assertEquals('locked', $milestone['status']);
            $this->assertNull($milestone['achieved_at']);
        }
    }

    /** @test */
    public function it_marks_milestones_as_achieved_when_weight_is_lost()
    {
        // User has lost 3kg
        $this->cuttingProgress->update(['current_weight' => 77.0]);

        StreakHelper::updateWeightMilestones($this->user);

        $this->cuttingProgress->refresh();
        $milestones = json_decode($this->cuttingProgress->milestones, true);

        // Find 1kg, 2kg, and 3kg milestones
        $milestone1kg = collect($milestones)->firstWhere('amount', 1);
        $milestone2kg = collect($milestones)->firstWhere('amount', 2);
        $milestone3kg = collect($milestones)->firstWhere('amount', 3);
        $milestone4kg = collect($milestones)->firstWhere('amount', 4);

        // First 3 should be achieved
        $this->assertEquals('achieved', $milestone1kg['status']);
        $this->assertEquals('achieved', $milestone2kg['status']);
        $this->assertEquals('achieved', $milestone3kg['status']);
        $this->assertEquals(now()->toDateString(), $milestone1kg['achieved_at']);

        // 4kg should be next
        $this->assertEquals('next', $milestone4kg['status']);
        $this->assertEquals('Soon!', $milestone4kg['display_date']);
    }

    /** @test */
    public function it_preserves_existing_milestone_achievements()
    {
        // Set up existing milestones with some already achieved
        $existingMilestones = [
            [
                'amount' => 1,
                'label' => '1kg Lost',
                'icon' => '🏆',
                'achieved_at' => '2024-01-15',
                'status' => 'achieved',
                'display_date' => 'Jan 15'
            ],
            [
                'amount' => 2,
                'label' => '2kg Lost',
                'icon' => '💪',
                'achieved_at' => '2024-01-20',
                'status' => 'achieved',
                'display_date' => 'Jan 20'
            ]
        ];

        $this->cuttingProgress->update([
            'current_weight' => 75.0, // Lost 5kg total
            'milestones' => json_encode($existingMilestones)
        ]);

        StreakHelper::updateWeightMilestones($this->user);

        $this->cuttingProgress->refresh();
        $milestones = json_decode($this->cuttingProgress->milestones, true);

        $milestone1kg = collect($milestones)->firstWhere('amount', 1);
        $milestone2kg = collect($milestones)->firstWhere('amount', 2);

        // Should preserve original achievement dates
        $this->assertEquals('2024-01-15', $milestone1kg['achieved_at']);
        $this->assertEquals('2024-01-20', $milestone2kg['achieved_at']);
        $this->assertEquals('achieved', $milestone1kg['status']);
        $this->assertEquals('achieved', $milestone2kg['status']);
    }

    /** @test */
    public function it_marks_goal_milestone_as_achieved_when_goal_is_reached()
    {
        // User has reached their goal (lost 10kg)
        $this->cuttingProgress->update(['current_weight' => 70.0]);

        StreakHelper::updateWeightMilestones($this->user);

        $this->cuttingProgress->refresh();
        $milestones = json_decode($this->cuttingProgress->milestones, true);

        $goalMilestone = collect($milestones)->firstWhere('label', 'Goal Reached');

        $this->assertEquals('achieved', $goalMilestone['status']);
        $this->assertEquals(now()->toDateString(), $goalMilestone['achieved_at']);
        $this->assertEquals('Completed!', $goalMilestone['display_date']);
    }

    /** @test */
    public function it_handles_partial_weight_loss_correctly()
    {
        // User has lost 2.5kg (between milestones)
        $this->cuttingProgress->update(['current_weight' => 77.5]);

        StreakHelper::updateWeightMilestones($this->user);

        $this->cuttingProgress->refresh();
        $milestones = json_decode($this->cuttingProgress->milestones, true);

        $milestone1kg = collect($milestones)->firstWhere('amount', 1);
        $milestone2kg = collect($milestones)->firstWhere('amount', 2);
        $milestone3kg = collect($milestones)->firstWhere('amount', 3);

        // 1kg and 2kg should be achieved
        $this->assertEquals('achieved', $milestone1kg['status']);
        $this->assertEquals('achieved', $milestone2kg['status']);

        // 3kg should be next
        $this->assertEquals('next', $milestone3kg['status']);
        $this->assertEquals('Soon!', $milestone3kg['display_date']);
    }

    /** @test */
    public function it_assigns_different_icons_to_milestones()
    {
        $this->cuttingProgress->update(['current_weight' => 75.0]); // Lost 5kg

        StreakHelper::updateWeightMilestones($this->user);

        $this->cuttingProgress->refresh();
        $milestones = json_decode($this->cuttingProgress->milestones, true);

        // Check that different milestones have different icons
        $milestone1kg = collect($milestones)->firstWhere('amount', 1);
        $milestone2kg = collect($milestones)->firstWhere('amount', 2);
        $goalMilestone = collect($milestones)->firstWhere('label', 'Goal Reached');

        $this->assertNotEmpty($milestone1kg['icon']);
        $this->assertNotEmpty($milestone2kg['icon']);
        $this->assertEquals('👑', $goalMilestone['icon']);
        $this->assertNotEquals($milestone1kg['icon'], $milestone2kg['icon']);
    }

    /** @test */
    public function it_handles_exceeding_goal_weight()
    {
        // User has lost more than their goal (12kg when goal was 10kg)
        $this->cuttingProgress->update(['current_weight' => 68.0]);

        StreakHelper::updateWeightMilestones($this->user);

        $this->cuttingProgress->refresh();
        $milestones = json_decode($this->cuttingProgress->milestones, true);

        // All milestones including goal should be achieved
        $goalMilestone = collect($milestones)->firstWhere('label', 'Goal Reached');
        $this->assertEquals('achieved', $goalMilestone['status']);

        // All weight milestones should be achieved
        $weightMilestones = collect($milestones)->where('label', '!=', 'Goal Reached');
        foreach ($weightMilestones as $milestone) {
            $this->assertEquals('achieved', $milestone['status']);
        }
    }

    /** @test */
    public function it_preserves_goal_milestone_achievement_date()
    {
        // Set up existing goal milestone
        $existingMilestones = [
            [
                'amount' => 10, // Assume total weight to lose is 10kg
                'label' => 'Goal Reached',
                'icon' => '👑',
                'achieved_at' => '2024-01-25',
                'status' => 'achieved',
                'display_date' => 'Jan 25'
            ]
        ];

        $this->cuttingProgress->update([
            'starting_weight' => 80.0,
            'goal_weight' => 70.0,
            'current_weight' => 70.0, // Indicates goal is achieved
            'milestones' => json_encode($existingMilestones)
        ]);

        StreakHelper::updateWeightMilestones($this->user);

        $this->cuttingProgress->refresh();
        $milestones = json_decode($this->cuttingProgress->milestones, true);

        $goalMilestone = collect($milestones)->firstWhere('label', 'Goal Reached');

        // Should preserve original achievement date
        $this->assertEquals('2024-01-25', $goalMilestone['achieved_at']);
        $this->assertEquals('achieved', $goalMilestone['status']);
    }


    /** @test */
    public function it_creates_correct_number_of_milestones_based_on_weight_goal()
    {
        // Test with different weight goals
        $this->cuttingProgress->update([
            'start_weight' => 85.0,
            'goal_weight' => 80.0, // Only 5kg to lose
            'current_weight' => 85.0
        ]);

        StreakHelper::updateWeightMilestones($this->user);

        $this->cuttingProgress->refresh();
        $milestones = json_decode($this->cuttingProgress->milestones, true);

        // Should have 5 weight milestones + 1 goal milestone = 6 total
        $this->assertCount(6, $milestones);

        $weightMilestones = collect($milestones)->where('label', '!=', 'Goal Reached');
        $this->assertCount(5, $weightMilestones);
    }
}
