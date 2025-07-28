<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WeightLog;
use App\Models\CuttingProgress;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $user = User::find(2);

    if ($user) {
      $user->update([
        'calorie_deficit' => 860,
        'maintaining_calorie' => 2660,
      ]);

      echo "✅ Updated user with ID 2: 860 kcal deficit from 2660 maintenance.\n";
    } else {
      echo "⚠️ User with ID 2 not found. No changes made.\n";
    }
  }
}
