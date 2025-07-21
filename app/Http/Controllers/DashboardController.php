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

        $user = auth()->user();
        $meals = $user->meals()->whereDate('date', Carbon::today())->get();
        $saved_meals = $user->saved_meals();

        $total_calories = $meals->sum('total_calories');
        $total_protein = $meals->sum('protein');
        $total_carbs = $meals->sum('carbs');
        $total_fat = $meals->sum('fat');
        $daily_macros_target = [
            [
                'label' => 'Calories',
                'daily_target' => $user->daily_calorie_target,
                'unit' => 'kcal',
                'left' => $user->daily_calorie_target - $total_calories,
            ],
            [
                'label' => 'Protein',
                'daily_target' => $user->daily_protein_target,
                'unit' => 'g',
                'left' => $user->daily_protein_target - $total_protein,
            ],
            [
                'label' => 'Carbs',
                'daily_target' => $user->daily_carbs_target,
                'unit' => 'g',
                'left' => $user->daily_carbs_target - $total_carbs,
            ],
            [
                'label' => 'Fat',
                'daily_target' => $user->daily_fat_target,
                'unit' => 'g',
                'left' => $user->daily_fat_target - $total_fat,
            ],
        ];


        return view("dashboard.index", compact('user', 'daily_macros_target', 'meals', 'saved_meals'));
    }
}
