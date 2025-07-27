<?php

namespace App\Http\Controllers;

use App\Models\CuttingProgress;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WeightTrackerController extends Controller
{

    // Update your controller method
    public function show(Request $request)
    {
        $user = auth()->user();
        $cuttingProgressInfo = CuttingProgress::where('user_id', $user->id)->first();

        $durationDays = $cuttingProgressInfo->duration_days;
        $startWeight = $cuttingProgressInfo->start_weight;
        $goalWeight = $cuttingProgressInfo->goal_weight;
        $currentWeight = $cuttingProgressInfo->current_weight ?? $startWeight; // Fallback if null

        $startDate = Carbon::parse($cuttingProgressInfo->started_at)->startOfDay();
        $today = Carbon::now()->startOfDay();
        $endDate = $startDate->copy()->addDays($durationDays - 1);

        $currentDay = $startDate->diffInDays($today) + 1;
        $currentDay = min($currentDay, $durationDays);

        // Calculate progress metrics
        $totalWeightToLose = $startWeight - $goalWeight;
        $weightLost = $startWeight - $currentWeight;
        $weightRemaining = $currentWeight - $goalWeight;
        $daysLeft = max(0, $durationDays - $currentDay);

        // Calculate percentages
        $weightProgressPercent = $totalWeightToLose > 0 ? min(100, ($weightLost / $totalWeightToLose) * 100) : 0;
        $timeProgressPercent = ($currentDay / $durationDays) * 100;

        // Calculate required rate (kg per week) for remaining period
        $weeksLeft = $daysLeft / 7;
        $rateNeeded = $weeksLeft > 0 ? $weightRemaining / $weeksLeft : 0;

        return view('weight-tracker.index', compact(
            'cuttingProgressInfo',
            'durationDays',
            'startWeight',
            'goalWeight',
            'currentWeight',
            'currentDay',
            'startDate',
            'endDate',
            'totalWeightToLose',
            'weightLost',
            'weightRemaining',
            'daysLeft',
            'weightProgressPercent',
            'timeProgressPercent',
            'rateNeeded'
        ));
    }
}
