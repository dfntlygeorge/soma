<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;

class CreateTemplateController extends Controller
{
    public function show(Request $request)
    {
        $meal = Meal::findOrFail($request->meal_id);

        return view("meals.templates.create", compact('meal'));
    }
}
