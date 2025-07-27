{{-- resources/views/components/progress-overview.blade.php --}}

<!-- Cut Progress Section -->
<div class="bg-gradient-to-r from-blue-900/30 to-purple-900/30 rounded-xl p-6 border border-blue-700/50 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-white">Cut Progress</h2>
        <div class="text-right">
            <div class="text-sm text-gray-300">Started: {{ $startDate->format('M j, Y') }}</div>
            <div class="text-sm text-gray-300">Target End: {{ $endDate->format('M j, Y') }}</div>
        </div>
    </div>

    <!-- Progress Bars -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Weight Progress -->
        <div>
            <div class="flex justify-between mb-2">
                <span class="text-sm text-gray-300">Weight Lost</span>
                <span class="text-sm text-blue-400 font-semibold">
                    {{ number_format($weightLost, 1) }}kg / {{ number_format($totalWeightToLose, 1) }}kg
                    ({{ number_format($weightProgressPercent, 0) }}%)
                </span>
            </div>
            <div class="w-full bg-gray-700 rounded-full h-3">
                <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-3 rounded-full"
                    style="width: {{ $weightProgressPercent }}%"></div>
            </div>
        </div>

        <!-- Time Progress -->
        <div>
            <div class="flex justify-between mb-2">
                <span class="text-sm text-gray-300">Days Completed</span>
                <span class="text-sm text-green-400 font-semibold">
                    {{ $currentDay }} / {{ $durationDays }} ({{ number_format($timeProgressPercent, 0) }}%)
                </span>
            </div>
            <div class="w-full bg-gray-700 rounded-full h-3">
                <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-3 rounded-full"
                    style="width: {{ $timeProgressPercent }}%"></div>
            </div>
        </div>
    </div>

    <!-- Key Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="text-center">
            <div class="text-2xl font-bold text-blue-400">{{ number_format($currentWeight, 1) }}kg</div>
            <div class="text-xs text-gray-400">Current Weight</div>
        </div>
        <div class="text-center">
            <div class="text-2xl font-bold text-purple-400">{{ number_format($weightRemaining, 1) }}kg</div>
            <div class="text-xs text-gray-400">Remaining</div>
        </div>
        <div class="text-center">
            <div class="text-2xl font-bold text-green-400">{{ $daysLeft }}</div>
            <div class="text-xs text-gray-400">Days Left</div>
        </div>
        <div class="text-center">
            <div class="text-2xl font-bold text-yellow-400">
                {{ $rateNeeded > 0 ? '-' . number_format($rateNeeded, 2) . 'kg/wk' : 'Goal Reached!' }}
            </div>
            <div class="text-xs text-gray-400">Rate Needed</div>
        </div>
    </div>
</div>
