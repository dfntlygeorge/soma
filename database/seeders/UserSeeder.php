<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = "George";
        $email = "g.a.donayre.personal@gmail.com";
        $password = bcrypt("password123");
        $daily_calorie_target = 1800;
        $daily_protein_target = 120;
        $daily_carbs_target = 170;
        $daily_fat_target = 50;

        DB::table("users")->insert([
            "name" => $name,
            'email'=> $email,
            'password'=> $password,
            'daily_calorie_target'=> $daily_calorie_target,
            'daily_protein_target'=> $daily_protein_target,
            'daily_carbs_target'=> $daily_carbs_target,
            'daily_fat_target'=> $daily_fat_target,
        ]);

    
        
    }
}