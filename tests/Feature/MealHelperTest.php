<?php

namespace Tests\Feature;

use App\Helpers\MealHelper;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Tests\TestCase;

class MealHelperTest extends TestCase
{
    /** @test */
    public function it_returns_empty_collection_when_meals_are_empty()
    {
        $meals = collect();
        $result = MealHelper::getDailySums($meals);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertTrue($result->isEmpty());
    }

    /** @test */
    public function it_groups_meals_by_date_and_sums_calories_and_protein()
    {
        $meals = collect([
            (object)[
                'date' => Carbon::parse('2025-07-22'),
                'total_calories' => 300,
                'protein' => 20,
            ],
            (object)[
                'date' => Carbon::parse('2025-07-22'),
                'total_calories' => 500,
                'protein' => 30,
            ],
            (object)[
                'date' => Carbon::parse('2025-07-23'),
                'total_calories' => 700,
                'protein' => 50,
            ],
        ]);

        $result = MealHelper::getDailySums($meals);

        $this->assertCount(2, $result);

        $this->assertEquals(800, $result['2025-07-22']['calories']);
        $this->assertEquals(50, $result['2025-07-22']['protein']);

        $this->assertEquals(700, $result['2025-07-23']['calories']);
        $this->assertEquals(50, $result['2025-07-23']['protein']);
    }

    /** @test */
    public function it_handles_dates_as_strings()
    {
        $meals = collect([
            (object)[
                'date' => '2025-07-22',
                'total_calories' => 300,
                'protein' => 20,
            ],
            (object)[
                'date' => '2025-07-22',
                'total_calories' => 500,
                'protein' => 30,
            ],
        ]);

        $result = MealHelper::getDailySums($meals);

        $this->assertCount(1, $result);
        $this->assertEquals(800, $result['2025-07-22']['calories']);
    }

    /** @test */
    public function it_calculates_correct_averages_for_a_week_with_meals()
    {
        $meals = collect([
            (object)[
                'date' => Carbon::parse('2025-07-21'),
                'total_calories' => 500,
                'protein' => 40,
            ],
            (object)[
                'date' => Carbon::parse('2025-07-21'),
                'total_calories' => 300,
                'protein' => 30,
            ],
            (object)[
                'date' => Carbon::parse('2025-07-22'),
                'total_calories' => 400,
                'protein' => 20,
            ],
        ]);

        $result = MealHelper::calculateDailyAverages($meals);

        $this->assertEquals(1200, $result['totalCalories']);
        $this->assertEquals(90, $result['totalProtein']);
        $this->assertEquals(2, $result['daysWithMeals']);
        $this->assertEquals(600, $result['averageCalories']);
        $this->assertEquals(45, $result['averageProtein']);
    }

    /** @test */
    public function it_returns_zeroed_stats_when_meals_are_empty()
    {
        $meals = collect();

        $result = MealHelper::calculateDailyAverages($meals);

        $this->assertEquals(0, $result['totalCalories']);
        $this->assertEquals(0, $result['totalProtein']);
        $this->assertEquals(0, $result['daysWithMeals']);
        $this->assertEquals(0, $result['averageCalories']);
        $this->assertEquals(0, $result['averageProtein']);
    }

    /** @test */
    public function it_correctly_groups_and_sums_meals_by_date()
    {
        $meals = collect([
            (object)[
                'date' => Carbon::parse('2025-07-22'),
                'total_calories' => 400,
                'protein' => 30,
            ],
            (object)[
                'date' => Carbon::parse('2025-07-22'),
                'total_calories' => 200,
                'protein' => 10,
            ],
        ]);

        $result = MealHelper::getDailySums($meals);

        $this->assertEquals(600, $result['2025-07-22']['calories']);
        $this->assertEquals(40, $result['2025-07-22']['protein']);
    }

    /** @test */
    public function it_fills_missing_dates_with_zero_and_sets_calories_when_data_exists()
    {
        $meals = collect([
            (object)[
                'date' => Carbon::parse('2025-07-21'),
                'total_calories' => 500,
                'protein' => 40,
            ],
            (object)[
                'date' => Carbon::parse('2025-07-23'),
                'total_calories' => 300,
                'protein' => 20,
            ],
        ]);

        $start = Carbon::parse('2025-07-21');
        $end = Carbon::parse('2025-07-24');

        $result = MealHelper::getDailyCaloriesForRange($meals, $start, $end);

        $this->assertEquals([
            '2025-07-21' => 500,
            '2025-07-22' => 0,
            '2025-07-23' => 300,
            '2025-07-24' => 0,
        ], $result);
    }
}
