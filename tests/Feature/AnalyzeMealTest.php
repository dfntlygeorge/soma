<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\GeminiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class AnalyzeMealTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function test_analyze_meal_works_normally_when_not_rate_limited(): void
    {
        // Mock the GeminiService
        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('analyzeMeal')
                ->once()
                ->with('Grilled chicken with rice')
                ->andReturn([
                    'calories' => 450,
                    'protein' => 35,
                    'carbs' => 40,
                    'fat' => 12
                ]);
        });

        $response = $this->actingAs($this->user)
            ->post('/meals/review', [
                'description' => 'Grilled chicken with rice'
            ]);

        $response->assertRedirect(route('dashboard'))
            ->assertSessionHas('review_macros')
            ->assertSessionHas('review_description', 'Grilled chicken with rice');
    }

    /** @test */
    public function test_analyze_meal_validation_fails_with_empty_description(): void
    {
        $response = $this->actingAs($this->user)
            ->post('/meals/review', [
                'description' => ''
            ]);

        $response->assertSessionHasErrors(['description']);
    }

    /** @test */
    public function test_analyze_meal_validation_fails_with_too_long_description(): void
    {
        $longDescription = str_repeat('a', 401); // 401 characters, over the 400 limit

        $response = $this->actingAs($this->user)
            ->post('/meals/review', [
                'description' => $longDescription
            ]);

        $response->assertSessionHasErrors(['description']);
    }

    /** @test */
    public function test_analyze_meal_allows_up_to_10_requests_per_day(): void
    {
        // Mock the GeminiService for multiple calls
        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('analyzeMeal')
                ->times(10)
                ->andReturn(['calories' => 300, 'protein' => 20, 'carbs' => 30, 'fat' => 10]);
        });

        // Make 10 requests (should all succeed)
        for ($i = 1; $i <= 10; $i++) {
            $response = $this->actingAs($this->user)
                ->post('/meals/review', [
                    'description' => "Meal description {$i}"
                ]);

            $response->assertRedirect(route('dashboard'));
        }
    }

    /** @test */
    public function test_analyze_meal_blocks_after_10_requests_per_day(): void
    {
        // Mock the GeminiService for exactly 10 calls
        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('analyzeMeal')
                ->times(10)
                ->andReturn(['calories' => 300, 'protein' => 20, 'carbs' => 30, 'fat' => 10]);
        });

        // Make 10 successful requests
        for ($i = 1; $i <= 10; $i++) {
            $this->actingAs($this->user)
                ->post('/meals/review', [
                    'description' => "Meal description {$i}"
                ]);
        }

        // 11th request should be rate limited
        $response = $this->actingAs($this->user)
            ->post('/meals/review', [
                'description' => 'This should be blocked'
            ]);

        $response->assertRedirect(route('rate-limit-exceeded'))
            ->assertSessionHas('feature', 'Meal Analysis')
            ->assertSessionHas('limit', '10 times per day');
    }

    /** @test */
    public function test_analyze_meal_rate_limit_is_per_user(): void
    {
        $anotherUser = User::factory()->create();

        // Mock the GeminiService
        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('analyzeMeal')
                ->times(11) // 10 for first user + 1 for second user
                ->andReturn(['calories' => 300, 'protein' => 20, 'carbs' => 30, 'fat' => 10]);
        });

        // First user makes 10 requests (max limit)
        for ($i = 1; $i <= 10; $i++) {
            $this->actingAs($this->user)
                ->post('/meals/review', [
                    'description' => "User 1 meal {$i}"
                ]);
        }

        // Second user should still be able to make requests
        $response = $this->actingAs($anotherUser)
            ->post('/meals/review', [
                'description' => 'User 2 first meal'
            ]);

        $response->assertRedirect(route('dashboard'));
    }

    /** @test */
    public function test_analyze_meal_requires_authentication(): void
    {
        $response = $this->post('/meals/review', [
            'description' => 'Some meal description'
        ]);

        $response->assertRedirect('/login'); // Adjust based on your auth redirect
    }

    /** @test */
    public function test_rate_limiter_key_is_unique_per_user(): void
    {
        $anotherUser = User::factory()->create();

        // Clear any existing rate limits
        RateLimiter::clear('analyze_' . $this->user->id);
        RateLimiter::clear('analyze_' . $anotherUser->id);

        // Hit rate limiter for first user
        RateLimiter::hit('analyze_' . $this->user->id, 86400);

        // Check that second user's rate limiter is independent
        $this->assertFalse(RateLimiter::tooManyAttempts('analyze_' . $anotherUser->id, 10));
        $this->assertEquals(1, RateLimiter::attempts('analyze_' . $this->user->id));
        $this->assertEquals(0, RateLimiter::attempts('analyze_' . $anotherUser->id));
    }

    protected function tearDown(): void
    {
        // Clean up rate limiters after each test
        if (isset($this->user)) {
            RateLimiter::clear('analyze_' . $this->user->id);
        }
        parent::tearDown();
    }
}