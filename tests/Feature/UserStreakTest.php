<?php

namespace Tests\Feature;

use App\Helpers\StreakHelper;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Meal;
use Carbon\Carbon;

class UserStreakTest extends TestCase
{
    use RefreshDatabase;

    public function test_streak_increments_if_user_logged_yesterday_and_logs_today()
    {
        // Simulate yesterday and today
        $yesterday = Carbon::yesterday()->startOfDay();
        $today = Carbon::today()->startOfDay();

        // Create a test user with yesterday as the last log
        $user = User::factory()->create([
            'streak' => 2,
            'longest_streak' => 2,
            'last_logged_at' => $yesterday,
            'earned_badges' => [],
        ]);

        // Simulate that they haven't logged a meal today
        // But we simulate the streak update call directly

        // Call the method manually — update this path depending where you put the method
        StreakHelper::updateUserStreak($user); // If it's a static method in the User model
        // OR: \App\Services\StreakService::updateUserStreak($user); // if in a service class

        // Reload from DB
        $user->refresh();

        $this->assertEquals(3, $user->streak);
        $this->assertEquals(3, $user->longest_streak);
        $this->assertEquals(Carbon::today()->toDateString(), $user->last_logged_at->toDateString());
    }

    public function test_streak_resets_if_user_skipped_a_day()
    {
        $user = User::factory()->create([
            'streak' => 5,
            'last_logged_at' => now()->subDays(2), // Skipped yesterday
            'earned_badges' => [],
        ]);

        StreakHelper::updateUserStreak($user);

        $user->refresh();

        $this->assertEquals(1, $user->streak);
        $this->assertEquals(Carbon::today()->toDateString(), $user->last_logged_at->toDateString());
    }

    public function test_streak_does_not_update_if_user_already_logged_today()
    {
        $user = User::factory()->create([
            'streak' => 4,
            'last_logged_at' => now()->subDay(),
            'earned_badges' => [],
        ]);

        Meal::factory()->create([
            'user_id' => $user->id,
            'created_at' => now(), // Logged today
        ]);

        StreakHelper::updateUserStreak($user);

        $user->refresh();

        $this->assertEquals(4, $user->streak);
        $this->assertEquals(Carbon::yesterday()->toDateString(), $user->last_logged_at->toDateString());
    }

    public function test_user_gets_badge_when_reaching_streak_milestone()
    {
        $user = User::factory()->create([
            'streak' => 2,
            'last_logged_at' => now()->subDay(),
            'earned_badges' => [],
        ]);

        StreakHelper::updateUserStreak($user);

        $user->refresh();

        $this->assertEquals(3, $user->streak);
        $this->assertContains('3_day', $user->earned_badges);
    }

    public function test_user_does_not_get_duplicate_badge()
    {
        $user = User::factory()->create([
            'streak' => 2,
            'last_logged_at' => now()->subDay(),
            'earned_badges' => ['3_day'],
        ]);

        StreakHelper::updateUserStreak($user);

        $user->refresh();

        // Should not get duplicate badge
        $this->assertEquals(3, $user->streak);
        $this->assertEquals(['3_day'], $user->earned_badges);
    }

    public function test_longest_streak_updates_when_surpassed()
    {
        $user = User::factory()->create([
            'streak' => 4,
            'longest_streak' => 4,
            'last_logged_at' => now()->subDay(),
        ]);

        StreakHelper::updateUserStreak($user);

        $user->refresh();

        $this->assertEquals(5, $user->streak);
        $this->assertEquals(5, $user->longest_streak);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Carbon::setTestNow(); // Reset time if it was mocked
    }
}
