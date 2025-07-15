<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\User;
use App\Services\MacroAnalyzerService;
use Carbon\Carbon;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{

    private MacroAnalyzerService $macroService;
    public function __construct(MacroAnalyzerService $macroService)
    {
        $this->macroService = $macroService;
    }
    // Show dashboard page

    public function index(): View
    {
        $user = User::first();

        $daily_macros_target = [
            [
                'label' => 'Calorie',
                'daily_target' => $user->daily_calorie_target,
                'unit' => 'kcal',
                'left' => 300, // HARDCODED FOR NOW
            ],
            [
                'label' => 'Protein',
                'daily_target' => $user->daily_protein_target,
                'unit' => 'g',
                'left' => 24, // HARDCODED FOR NOW
            ],
            [
                'label' => 'Carbs',
                'daily_target' => $user->daily_carbs_target,
                'unit' => 'g',
                'left' => 36, // HARDCODED FOR NOW
            ],
            [
                'label' => 'Fat',
                'daily_target' => $user->daily_fat_target,
                'unit' => 'g',
                'left' => 12, // HARDCODED FOR NOW
            ],
        ];

        $meals = Meal::where('user_id', $user->id)->get();

        // $mealDescription = "I ate 200g of chicken pastil all chicken breast meat with 150g of red rice.";

        // $macros = $this->macroService->analyze($mealDescription);

        // Meal::create([
        //     'user_id' => $user->id,
        //     'description' => $macros['description'],
        //     'total_calories' => $macros['total_calories'],
        //     'protein' => $macros['protein'],
        //     'carbs' => $macros['carbs'],
        //     'fat' => $macros['fat'],
        //     'date' => Carbon::today(),
        // ]);



        return view("dashboard.index", compact('user', 'daily_macros_target', 'meals'));
    }
}
