<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Services\MacroAnalyzerService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MealController extends Controller
{
    private MacroAnalyzerService $macroAnalyzerService;
    public function __construct(MacroAnalyzerService $macroAnalyzerService)
    {
        $this->macroAnalyzerService = $macroAnalyzerService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:1000',
        ]);

        $description = $request->description;

        // get macros


        $macros = $this->macroAnalyzerService->analyze($description);

        Meal::create([
            'user_id' => 1,
            'description' => $macros['description'],
            'total_calories' => $macros['total_calories'],
            'protein' => $macros['protein'],
            'carbs' => $macros['carbs'],
            'fat' => $macros['fat'],
            'date' => Carbon::today(),
        ]);

        return redirect()->back()->with('success', 'Meal logges successfully');
    }
}
