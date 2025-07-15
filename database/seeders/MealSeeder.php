<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('meals')->insert([
            [
                'user_id' => 1,
                'description' => 'Oatmeal with berries',
                'total_calories' => 330,
                'protein' => 9,
                'carbs' => 55,
                'fat' => 7,
                'date' => Carbon::today(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'description' => 'Chicken sandwich with rice',
                'total_calories' => 870,
                'protein' => 36,
                'carbs' => 123,
                'fat' => 20,
                'date' => Carbon::today(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'description' => 'Salmon with vegetables',
                'total_calories' => 740,
                'protein' => 51,
                'carbs' => 36,
                'fat' => 44,
                'date' => Carbon::today(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}