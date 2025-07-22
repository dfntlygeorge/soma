<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\SavedMeal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // Update your user (assuming ID = 1)
    $user = User::find(2); // or use whatever ID your account is

    if ($user) {
      $user->streak = 4;
      $user->longest_streak = max($user->longest_streak, 4); // keep max
      $user->last_logged_at = Carbon::now()->startOfDay();
      $user->earned_badges = ['3_day']; // Optional if earned

      $user->save();
    }
  }
}
