<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MacroController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->user();
        $daily_calorie_target = $request->input('daily_calorie_target');
        $daily_protein_target =  $request->input('daily_protein_target');
        $daily_carbs_target =  $request->input('daily_carbs_target');
        $daily_fat_target =  $request->input('daily_fat_target');

        $user->update([
            'daily_calorie_target' => $daily_calorie_target,
            'daily_protein_target' => $daily_protein_target,
            'daily_carbs_target' => $daily_carbs_target,
            'daily_fat_target' => $daily_fat_target,
        ]);

        return redirect()->route('dashboard')->with('success', 'Daily macros updated successfully');
    }

    public function show()
    {
        $user = auth()->user();
        $daily_calorie_target = $user->daily_calorie_target;
        $daily_protein_target = $user->daily_protein_target;
        $daily_carbs_target = $user->daily_carbs_target;
        $daily_fat_target = $user->daily_fat_target;

        return view('macros.edit', compact('daily_calorie_target', 'daily_protein_target', 'daily_carbs_target', 'daily_fat_target'));
    }
}
