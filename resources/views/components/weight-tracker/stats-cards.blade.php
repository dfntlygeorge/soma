{{-- resources/views/components/stats-cards.blade.php --}}

<!-- Current Stats Cards -->
<div class="lg:col-span-1 space-y-4">
    <!-- Current Weight Card -->
    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-300">Current Weight</h3>
            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
        </div>
        <div class="text-3xl font-bold text-white mb-2">{{ $statsData['current_weight']['weight'] }} kg</div>
        <div class="flex items-center text-sm">
            <span class="text-red-400">↓ {{ $statsData['current_weight']['total_lost'] }}kg from start</span>
        </div>
        <div class="text-xs text-gray-500 mt-1">Last logged: {{ $statsData['current_weight']['last_logged'] }}</div>
    </div>

    <!-- Goal Weight Card -->
    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-300">Goal Weight</h3>
            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
        </div>
        <div class="text-3xl font-bold text-white mb-2">{{ $statsData['goal_weight']['goal_weight'] }} kg</div>
        <div class="text-sm text-gray-400">{{ $statsData['goal_weight']['weight_remaining'] }} kg to go</div>
        <div class="text-xs text-gray-500 mt-1">Est. {{ $statsData['goal_weight']['estimated_weeks'] }}</div>
    </div>

    <!-- Next Week Prediction -->
    <div class="bg-gradient-to-br from-green-900/30 to-green-800/30 rounded-xl p-6 border border-green-700/50">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-green-300">Next Week Prediction</h3>
            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
        </div>
        <div class="text-3xl font-bold text-white mb-2">{{ $statsData['prediction']['predicted_weight'] }} kg</div>
        <div class="text-sm text-green-400 mb-3">↓ {{ $statsData['prediction']['predicted_loss'] }}kg predicted loss
        </div>
        <div class="text-xs text-gray-400">Based on {{ $statsData['prediction']['calorie_deficit'] }} kcal daily deficit
        </div>
        <div class="mt-3 text-xs text-gray-500">Week of {{ $statsData['prediction']['week_range'] }}</div>
    </div>
</div>
