<?php

namespace Database\Factories;

use App\Models\CuttingProgress;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CuttingProgress>
 */
class CuttingProgressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CuttingProgress::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startWeight = $this->faker->numberBetween(70, 100);
        $goalWeight = $this->faker->numberBetween(60, $startWeight - 5); // Ensure goal is less than start

        return [
            'user_id' => User::factory(),
            'start_weight' => $startWeight,
            'goal_weight' => $goalWeight,
            'current_weight' => $this->faker->numberBetween($goalWeight, $startWeight),
            'duration_days' => $this->faker->numberBetween(30, 180),
            'started_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'milestones' => json_encode([]),
        ];
    }
}
