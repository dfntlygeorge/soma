<?php

namespace App\Http\Controllers;

use App\Helpers\MealHelper;
use App\Models\Meal;
use App\Services\MacroAnalyzerService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ChartService;

class MealController extends Controller
{
    private MacroAnalyzerService $macroAnalyzerService;
    public function __construct(MacroAnalyzerService $macroAnalyzerService)
    {
        $this->macroAnalyzerService = $macroAnalyzerService;
    }

    public function analyze(Request $request)
    {

        $request->validate([
            'description' => 'required|string|max:400',
        ]);

        $description = $request->description;

        $macros = $this->macroAnalyzerService->analyze($description);

        return redirect()->route('dashboard')->with(['review_macros' => $macros, 'review_description' => $description]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => 'required|string',
            'total_calories' => 'required|numeric',
            'protein' => 'required|numeric',
            'carbs' => 'required|numeric',
            'fat' => 'required|numeric',
        ]);
        $user_id = auth()->user()->id;

        Meal::create([
            'user_id' => $user_id,
            'description' => $data['description'],
            'total_calories' => $data['total_calories'],
            'protein' => $data['protein'],
            'carbs' => $data['carbs'],
            'fat' => $data['fat'],
            'date' => now(),
        ]);

        return redirect()->route(
            'dashboard'
        )->with('success', 'Meal logged successfully!');
    }

    public function destroy(Meal $meal)
    {
        $meal->delete();

        return redirect()->back()->with('success', 'Meal deleted successfully');
    }

    public function edit(Meal $meal)
    {
        return view("meals.edit", compact('meal'));
    }
    public function update(Request $request, Meal $meal)
    {
        $data = $request->validate([
            'description' => 'required|string',
            'total_calories' => 'required|numeric',
            'protein' => 'required|numeric',
            'carbs' => 'required|numeric',
            'fat' => 'required|numeric',
        ]);

        $meal->update([
            'description' => $data['description'],
            'total_calories' => $data['total_calories'],
            'protein' => $data['protein'],
            'carbs' => $data['carbs'],
            'fat' => $data['fat'],
        ]);

        return redirect()->route('dashboard')->with('success', 'Meal edited successfully!');
    }

    public function history(ChartService $chartService)
    {
        // Get user's meals
        $meals = auth()->user()->meals()->get();

        // Calculate daily averages using helper function (no more duplicate logic!)
        $averages = MealHelper::calculateDailyAverages($meals);

        // Get chart data
        $chart = $chartService->weeklyCaloriesChart($meals);

        // Get formatted current week range
        $weekRange = MealHelper::getCurrentWeekRange();

        return view("meals.history", compact(
            'meals',
            'chart',
            'weekRange'
        ) + $averages); // This spreads averageCalories, averageProtein, daysWithMeals, totalCalories, totalProtein
    }
}
