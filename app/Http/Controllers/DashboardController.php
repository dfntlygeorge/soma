<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{

    // Show dashboard page

    public function index(): View
    {
        $user = User::first();
        $meals = Meal::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())
            ->get();
        $total_calories = $meals->sum('total_calories');
        $total_protein = $meals->sum('protein');
        $total_carbs = $meals->sum('carbs');
        $total_fat = $meals->sum('fat');
        $daily_macros_target = [
            [
                'label' => 'Calorie',
                'daily_target' => $user->daily_calorie_target,
                'unit' => 'kcal',
                'left' => max($user->daily_calorie_target - $total_calories, 0),
            ],
            [
                'label' => 'Protein',
                'daily_target' => $user->daily_protein_target,
                'unit' => 'g',
                'left' => max($user->daily_protein_target - $total_protein, 0)
            ],
            [
                'label' => 'Carbs',
                'daily_target' => $user->daily_carbs_target,
                'unit' => 'g',
                'left' => max($user->daily_carbs_target - $total_carbs, 0)
            ],
            [
                'label' => 'Fat',
                'daily_target' => $user->daily_fat_target,
                'unit' => 'g',
                'left' => max($user->daily_fat_target - $total_fat, 0)
            ],
        ];


        return view("dashboard.index", compact('user', 'daily_macros_target', 'meals'));
    }
}
