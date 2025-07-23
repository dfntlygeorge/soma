<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Meal;
use App\Models\User;

class MealFactory extends Factory
{
    protected $model = Meal::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // You can override this in tests
            'description' => $this->faker->sentence(4),
            'total_calories' => $this->faker->numberBetween(200, 800),
            'protein' => $this->faker->numberBetween(10, 60),
            'carbs' => $this->faker->numberBetween(20, 100),
            'fat' => $this->faker->numberBetween(5, 30),
            'date' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
            'category' => $this->faker->randomElement(['breakfast', 'lunch', 'dinner', 'snack']),
            'saved_meal_id' => null, // or $this->faker->randomNumber() if needed
        ];
    }
}
