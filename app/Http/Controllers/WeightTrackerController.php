<?php

namespace App\Http\Controllers;

use App\Helpers\ChartHelper;
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

        return redirect()->back()->with('success', 'Weight logged successfully!');
    }
}
