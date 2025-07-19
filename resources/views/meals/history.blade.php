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
        {{-- Daily History --}}
        <div class="space-y-4 px-4 py-4 ">
            <!-- Today -->
            <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
                <!-- Date Header -->
                <div class="bg-gray-750 px-5 py-4 border-b border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-medium text-gray-100">Today</h3>
                            {{-- make it dynamic --}}
                            <p class="text-sm text-gray-400">{{ now()->format('l, F j, Y') }}</p>

                        </div>
                        <div class="text-right">
                            <div class="text-lg font-semibold text-olive-400">{{ $calories }} cal</div>
                            <div class="text-xs text-gray-400">Total</div>
                        </div>
                    </div>

                    <!-- Daily Macro Summary -->
                    <div class="grid grid-cols-3 gap-4 mt-4">
                        <div class="text-center">
                            <div class="text-lg font-semibold text-red-400">{{ $carbs }}g</div>
                            <div class="text-xs text-gray-400">Carbs</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-semibold text-blue-400">{{ $protein }}g</div>
                            <div class="text-xs text-gray-400">Protein</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-semibold text-yellow-400">{{ $fat }}g</div>
                            <div class="text-xs text-gray-400">Fat</div>
                        </div>
                    </div>
                </div>

                <!-- Meals List -->
                <div class="divide-y divide-gray-700">
                    @forelse ($meals_today->groupBy('category') as $category => $meals)
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-3 h-3 {{ match ($category) {
                                            'breakfast' => 'bg-orange-400',
                                            'lunch' => 'bg-green-400',
                                            'dinner' => 'bg-purple-400',
                                            'snack' => 'bg-pink-400',
                                            default => 'bg-gray-400',
                                        } }} rounded-full">
                                    </div>
                                    <span class="font-medium text-gray-200 capitalize">{{ $category }}</span>
                                </div>
                                <span class="text-sm text-gray-400">
                                    {{-- Optional: show time of the first meal in this category --}}
                                    {{ \Carbon\Carbon::parse($meals->first()->created_at)->format('g:i A') }}
                                </span>
                            </div>

                            @foreach ($meals as $meal)
                                <div class="bg-gray-700/30 rounded-lg p-3 mb-2">
                                    <p class="text-sm text-gray-300 mb-2">{{ $meal->description }}</p>
                                    <div class="flex justify-between text-xs text-gray-400">
                                        <span>{{ $meal->total_calories }} cal</span>
                                        <span>
                                            C: {{ $meal->carbs }}g • P: {{ $meal->protein }}g • F:
                                            {{ $meal->fat }}g
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @empty
                        <div class="p-4 text-center text-gray-400">
                            No meals logged for today.
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
</x-app-layout>
