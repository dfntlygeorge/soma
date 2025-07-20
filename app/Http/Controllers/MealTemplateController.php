<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\SavedMeal;
use Illuminate\Http\Request;

class MealTemplateController extends Controller
{
    // store the meal template

    public function store(Request $request)
    {
        // we need the meal itself here,
        $user = auth()->user();
        $meal_id = $request->input("meal_id");
        $name = $request->input("name");
        $meal = Meal::findOrFail($meal_id);


        $saved_meal = SavedMeal::create([
            'user_id' => $user->id,
            'name' => $name, // change to user input
            'category' => $meal->category,
            'calories' => $meal->total_calories,
            'protein' => $meal->protein,
            'carbs' => $meal->carbs,
            'fat' => $meal->fat,
        ]);

        $meal->update(['saved_meal_id' => $saved_meal->id]);
        // redirect to meals/template in the future
        return redirect()->route('dashboard')->with('success', 'Template Created Successfully');
    }
}
