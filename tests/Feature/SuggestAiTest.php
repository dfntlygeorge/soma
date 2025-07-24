<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\GeminiService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class SuggestAiTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'daily_calorie_target' => 2000
        ]);
    }

    /**
     * Get mock meal suggestions in the correct format
     */
    private function getMockSuggestions(): array
    {
        return [
            [
                "name" => "Chicken Adobo Bowl",
                "description" => "Tender adobo chicken served with steamed rice and sautéed kangkong — because unlike some people, this one won't leave you hanging after being well-seasoned.",
                "calories" => 430,
                "protein" => 32,
                "carbs" => 40,
                "fat" => 18,
                "pantry_match" => 90
            ],
            [
                "name" => "Gising-Gising with Ground Pork",
                "description" => "Spicy green beans in creamy coconut milk with ground pork — proof that being hot and messy can still be comforting.",
                "calories" => 390,
                "protein" => 28,
                "carbs" => 22,
                "fat" => 24,
                "pantry_match" => 85
            ],
            [
                "name" => "Tinolang Manok",
                "description" => "Chicken tinola with malunggay and papaya — for the days when you just want something warm to hold onto, even if it's just sabaw.",
                "calories" => 360,
                "protein" => 30,
                "carbs" => 18,
                "fat" => 16,
                "pantry_match" => 88
            ]
        ];
    }

    /** @test */
    public function test_suggest_ai_works_normally_when_not_rate_limited(): void
    {
        // Mock the GeminiService with correct return format
        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('suggestMeal')
                ->once()
                ->andReturn($this->getMockSuggestions());
        });

        $response = $this->actingAs($this->user)
            ->post('/charmy/suggest-ai');

        $response->assertStatus(200)
            ->assertViewIs('charmy.index')
            ->assertViewHas('suggestions');

        // Verify the suggestions structure
        $suggestions = $response->viewData('suggestions');
        $this->assertIsArray($suggestions);
        $this->assertCount(3, $suggestions);
        $this->assertArrayHasKey('name', $suggestions[0]);
        $this->assertArrayHasKey('calories', $suggestions[0]);
    }

    /** @test */
    public function test_suggest_ai_allows_up_to_5_requests_per_day(): void
    {
        // Mock the GeminiService for multiple calls
        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('suggestMeal')
                ->times(5)
                ->andReturn($this->getMockSuggestions());
        });

        // Make 5 requests (should all succeed)
        for ($i = 1; $i <= 5; $i++) {
            $response = $this->actingAs($this->user)
                ->post('/charmy/suggest-ai');

            $response->assertStatus(200)
                ->assertViewIs('charmy.index');
        }
    }

    /** @test */
    public function test_suggest_ai_blocks_after_5_requests_per_day(): void
    {
        // Mock the GeminiService for exactly 5 calls
        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('suggestMeal')
                ->times(5)
                ->andReturn($this->getMockSuggestions());
        });

        // Make 5 successful requests
        for ($i = 1; $i <= 5; $i++) {
            $this->actingAs($this->user)
                ->post('/charmy/suggest-ai');
        }

        // 6th request should be rate limited
        $response = $this->actingAs($this->user)
            ->post('/charmy/suggest-ai');

        $response->assertRedirect(route('rate-limit-exceeded'))
            ->assertSessionHas('feature', 'AI Meal Suggestions')
            ->assertSessionHas('limit', '5 times per day');
    }

    /** @test */
    public function test_suggest_ai_rate_limit_is_per_user(): void
    {
        $anotherUser = User::factory()->create([
            'daily_calorie_target' => 1800
        ]);

        // Mock the GeminiService
        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('suggestMeal')
                ->times(6) // 5 for first user + 1 for second user
                ->andReturn($this->getMockSuggestions());
        });

        // First user makes 5 requests (max limit)
        for ($i = 1; $i <= 5; $i++) {
            $response = $this->actingAs($this->user)
                ->post('/charmy/suggest-ai');

            // Add better error handling
            if ($response->status() !== 200) {
                // Get the actual error for debugging
                $content = $response->getContent();
                $this->fail("Request $i failed with status: " . $response->status() . ". Content: " . substr($content, 0, 500));
            }
        }

        // Second user should still be able to make requests
        $response = $this->actingAs($anotherUser)
            ->post('/charmy/suggest-ai');

        $response->assertStatus(200)
            ->assertViewIs('charmy.index');
    }

    /** @test */
    public function test_suggest_ai_requires_authentication(): void
    {
        $response = $this->post('/charmy/suggest-ai');

        $response->assertRedirect('/login'); // Adjust based on your auth redirect
    }

    /** @test */
    public function test_suggest_ai_calculates_calories_correctly_with_no_meals(): void
    {
        // Mock the GeminiService to capture the parameters
        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('suggestMeal')
                ->once()
                ->with('', 666) // 2000 / 3 = 666 (rounded down)
                ->andReturn($this->getMockSuggestions());
        });

        $response = $this->actingAs($this->user)
            ->post('/charmy/suggest-ai');

        $response->assertStatus(200);
    }



    /** @test */
    public function test_suggest_ai_handles_user_with_ingredients(): void
    {
        // Create some ingredients for the user
        $this->user->ingredients()->createMany([
            ['name' => 'Chicken breast'],
            ['name' => 'Brown rice'],
            ['name' => 'Broccoli']
        ]);

        // Mock the GeminiService to verify ingredients are passed
        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('suggestMeal')
                ->once()
                ->with('Chicken breast, Brown rice, Broccoli', 666)
                ->andReturn($this->getMockSuggestions());
        });

        $response = $this->actingAs($this->user)
            ->post('/charmy/suggest-ai');

        $response->assertStatus(200);
    }

    /** @test */
    public function test_rate_limiter_key_is_unique_per_user(): void
    {
        $anotherUser = User::factory()->create();

        // Clear any existing rate limits
        RateLimiter::clear('suggest_' . $this->user->id);
        RateLimiter::clear('suggest_' . $anotherUser->id);

        // Hit rate limiter for first user
        RateLimiter::hit('suggest_' . $this->user->id, 86400);

        // Check that second user's rate limiter is independent
        $this->assertFalse(RateLimiter::tooManyAttempts('suggest_' . $anotherUser->id, 5));
        $this->assertEquals(1, RateLimiter::attempts('suggest_' . $this->user->id));
        $this->assertEquals(0, RateLimiter::attempts('suggest_' . $anotherUser->id));
    }

    /** @test */
    public function test_suggestions_contain_required_fields(): void
    {
        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('suggestMeal')
                ->once()
                ->andReturn($this->getMockSuggestions());
        });

        $response = $this->actingAs($this->user)
            ->post('/charmy/suggest-ai');

        $response->assertStatus(200);

        $suggestions = $response->viewData('suggestions');

        foreach ($suggestions as $suggestion) {
            $this->assertArrayHasKey('name', $suggestion);
            $this->assertArrayHasKey('description', $suggestion);
            $this->assertArrayHasKey('calories', $suggestion);
            $this->assertArrayHasKey('protein', $suggestion);
            $this->assertArrayHasKey('carbs', $suggestion);
            $this->assertArrayHasKey('fat', $suggestion);
            $this->assertArrayHasKey('pantry_match', $suggestion);

            // Ensure numeric values are actually numeric
            $this->assertIsNumeric($suggestion['calories']);
            $this->assertIsNumeric($suggestion['protein']);
            $this->assertIsNumeric($suggestion['carbs']);
            $this->assertIsNumeric($suggestion['fat']);
            $this->assertIsNumeric($suggestion['pantry_match']);
        }
    }

    protected function tearDown(): void
    {
        // Clean up rate limiters after each test
        if (isset($this->user)) {
            RateLimiter::clear('suggest_' . $this->user->id);
        }
        parent::tearDown();
    }
}