<?php

namespace App\Http\Controllers;

use App\Models\SavedMeal;
use Illuminate\Http\Request;

class EditTemplateController extends Controller
{
    public function show(Request $request)

    {
        $meal_template = SavedMeal::findOrFail($request->query("meal_template_id"));
        return view('meals.templates.edit', compact('meal_template'));
    }

    public function update(Request $request, SavedMeal $meal_template)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Find the saved meal template by ID

        // Update only the name
        $meal_template->update(
            [
                'name' => $request->input('name'),
            ]
        );

        // Redirect back or to another page with success
        return redirect()->route('meal-templates.index')->with('success', 'Meal template updated successfully.');
    }
    public function destroy(SavedMeal $meal_template)
    {
        $meal_template->delete();

        return redirect()->route('meal-templates.index')->with('success', 'Meal template deleted successfully.');
    }


    public function index()
    {
        return view('meals.templates.index');
    }
}
