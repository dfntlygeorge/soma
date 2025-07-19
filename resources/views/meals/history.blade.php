<x-app-layout>
    <div class="bg-gray-900 text-gray-100 min-h-screen">
        <div class="bg-gray-800 border-b border-gray-700 px-4 py-4 sticky top-0 z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <h1 class="text-xl font-semibold text-gray-100">My Meals History</h1>
                </div>
                <button class="text-olive-400 hover:text-olive-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
        {{-- Weekly Summary card --}}

        <div class="px-4 py-4 space-y-6">
            <div class="bg-gray-800 rounded-xl p-5 border border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-medium text-gray-100">This Week</h2>
                    <span class="text-sm text-gray-400">{{ $weekRange }}</span>
                </div>

                <!-- Weekly Stats Grid -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="bg-gray-700/50 rounded-lg p-3">
                        <div class="text-2xl font-bold text-olive-400">{{ $averageCalories }}kcal</div>
                        <div class="text-sm text-gray-400">Avg Calories/day</div>
                    </div>
                    <div class="bg-gray-700/50 rounded-lg p-3">
                        <div class="text-2xl font-bold text-blue-400">{{ $averageProtein }}g</div>
                        <div class="text-sm text-gray-400">Avg Protein/day</div>
                    </div>
                </div>

                <!-- Weekly Chart -->
                <div class="bg-gray-700/30 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-gray-300 mb-3">Daily Calories This Week</h3>
                    <div style="height: 200px;">
                        <x-chartjs-component :chart="$chart" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
