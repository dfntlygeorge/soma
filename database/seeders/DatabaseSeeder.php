<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CuttingProgress;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    CuttingProgress::updateOrCreate(
      ['user_id' => 2], // Find by this
      [
        'started_at' => Carbon::create(2025, 7, 19),
        'current_weight' => 76.0,
        'start_weight' => 78.0,
        'goal_weight' => 65.0,
        'duration_days' => 130,
        'milestones' => json_encode([
          [
            'label' => '1kg Lost',
            'amount' => 1,
            'achieved_at' => '2025-07-20',
            'icon' => '🏆',
          ],
          [
            'label' => '2kg Lost',
            'amount' => 2,
            'achieved_at' => '2025-07-24',
            'icon' => '💪',
          ]
        ]),
        'active' => true,
      ]
    );
  }
}
