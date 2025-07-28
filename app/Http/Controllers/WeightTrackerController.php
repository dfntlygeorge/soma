<?php

namespace App\Http\Controllers;

use App\Helpers\ChartHelper;
use App\Helpers\StreakHelper;
use App\Helpers\WeightTrackerHelper;
use App\Models\CuttingProgress;
use App\Models\WeightLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WeightTrackerController extends Controller
{

    public function show(Request $request)
    {
        $user = auth()->user();
        $cuttingProgressInfo = CuttingProgress::where('user_id', $user->id)->first();

        // If no cutting progress exists, show empty state
        if (!$cuttingProgressInfo) {
            return view('weight-tracker.empty-state');
        }

        $metrics = WeightTrackerHelper::calculateMetrics($cuttingProgressInfo);

        // Process milestones using the helper
        $milestones = WeightTrackerHelper::processMilestones(
            $cuttingProgressInfo->milestones,
            $metrics
        );

        // Get stats data for the cards
        $statsData = WeightTrackerHelper::getStatsData($user->id, $metrics);

        // Fetch weight logs for the table
        $weightLogs = WeightLog::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();

        // Format weight logs data
        $formattedWeightLogs = WeightTrackerHelper::formatWeightLogsForTable($weightLogs);

        // Build weight progress chart
        $weightChart = ChartHelper::buildWeightProgressChart($user->id, $metrics['goalWeight']);
        // dd($weightChart);

        return view('weight-tracker.index', array_merge([
            'milestones' => $milestones,
            'statsData' => $statsData,
            'weightLogs' => $formattedWeightLogs,
            'totalEntries' => WeightLog::where('user_id', $user->id)->count(),
            'chart' => $weightChart
        ], $metrics));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        // TODO: UPDATE USERS CUTTING PROGRESS CURRENT WEIGHT.

        // Validate the request
        $validated = $request->validate([
            'weight' => 'required|numeric|min:0|max:1000',
            'date' => 'required|date|before_or_equal:today',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Get the latest weight log to calculate changes
        $latestLog = $user->weight_logs()->latest('date')->first();

        $change = null;
        $totalLost = 0;

        if ($latestLog) {
            // Calculate change from previous entry
            $change = $validated['weight'] - $latestLog->weight;

            // Calculate total lost from the first entry
            $firstLog = $user->weight_logs()->oldest('date')->first();
            if ($firstLog) {
                $totalLost = $firstLog->weight - $validated['weight'];
            }
        }

        // Create the new weight log
        $weightLog = $user->weight_logs()->create([
            'date' => $validated['date'],
            'weight' => $validated['weight'],
            'change' => $change,
            'total_lost' => $totalLost,
            'notes' => $validated['notes']
        ]);

        // Update milestone achievements
        StreakHelper::updateWeightMilestones($user);

        return redirect()->back()->with('success', 'Weight logged successfully!');
    }

    public function initializeCutting(Request $request)
    {
        $user = auth()->user();

        // Validate the request
        $validated = $request->validate([
            'start_weight' => 'required|numeric|min:0|max:1000',
            'goal_weight' => 'required|numeric|min:0|max:1000',
        ]);

        // Ensure goal weight is less than start weight for cutting
        if ($validated['goal_weight'] >= $validated['start_weight']) {
            return redirect()->back()->withErrors([
                'goal_weight' => 'Goal weight must be less than start weight for cutting.'
            ]);
        }

        // Calculate duration in days based on weight difference and calorie deficit
        $weightToLose = $validated['start_weight'] - $validated['goal_weight'];
        $calorieDeficit = $user->calorie_deficit ?? 500; // Default to 500 if not set

        // 1 kg = ~7700 calories, so days = (kg_to_lose * 7700) / daily_deficit
        $durationDays = ceil(($weightToLose * 7700) / $calorieDeficit);

        // Create cutting progress record
        $cuttingProgress = CuttingProgress::create([
            'user_id' => $user->id,
            'started_at' => Carbon::today(),
            'start_weight' => $validated['start_weight'],
            'goal_weight' => $validated['goal_weight'],
            'current_weight' => $validated['start_weight'], // Initialize with start weight
            'duration_days' => $durationDays,
            'active' => 1,
        ]);

        // Create initial weight log entry
        WeightLog::create([
            'user_id' => $user->id,
            'date' => Carbon::today(),
            'weight' => $validated['start_weight'],
            'change' => null, // First entry has no change
            'total_lost' => 0,
            'notes' => 'Initial weight entry'
        ]);

        return redirect()->route('weight-tracker.show')->with('success', 'Cutting journey started successfully!');
    }
}
