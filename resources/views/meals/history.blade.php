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
        <div class="space-y-4 px-4 py-4">
            @forelse($dailyMealData as $dayData)
                <div
                    class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden 
                    {{ !$dayData['has_data'] ? 'bg-gray-800/50 border-gray-700/50 opacity-60' : '' }}">

                    <!-- Date Header -->
                    <div class="bg-gray-750 px-5 py-4 border-b border-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-100">{{ $dayData['day_label'] }}</h3>
                                <p class="text-sm text-gray-400">{{ $dayData['date_formatted'] }}</p>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-semibold text-olive-400">
                                    {{ $dayData['macro_sums']['calories'] ?? 0 }} cal
                                </div>
                                <div class="text-xs text-gray-400">Total</div>
                            </div>
                        </div>

                        <!-- Daily Macro Summary -->
                        @if ($dayData['has_data'])
                            <div class="grid grid-cols-3 gap-4 mt-4">
                                <div class="text-center">
                                    <div class="text-lg font-semibold text-red-400">
                                        {{ $dayData['macro_sums']['carbs'] ?? 0 }}g</div>
                                    <div class="text-xs text-gray-400">Carbs</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-semibold text-blue-400">
                                        {{ $dayData['macro_sums']['protein'] ?? 0 }}g</div>
                                    <div class="text-xs text-gray-400">Protein</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-semibold text-yellow-400">
                                        {{ $dayData['macro_sums']['fat'] ?? 0 }}g</div>
                                    <div class="text-xs text-gray-400">Fat</div>
                                </div>
                            </div>
                        @else
                            <div class="mt-4 p-3 bg-gray-700/30 rounded-lg text-center">
                                <p class="text-sm text-gray-400">No macros to display</p>
                            </div>
                        @endif
                    </div>

                    <!-- Meals Content -->
                    @if ($dayData['day_index'] === 0)
                        {{-- Today - Show full meal details --}}
                        <div class="divide-y divide-gray-700">
                            @if ($dayData['meals']->isNotEmpty())
                                @foreach ($dayData['meals']->groupBy('category') as $category => $meals)
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
                                                <span
                                                    class="font-medium text-gray-200 capitalize">{{ $category }}</span>
                                            </div>
                                            <span class="text-sm text-gray-400">
                                                {{ \Carbon\Carbon::parse($meals->first()->created_at)->format('g:i A') }}
                                            </span>
                                        </div>

                                        @foreach ($meals as $meal)
                                            <div class="bg-gray-700/30 rounded-lg p-3 mb-2">
                                                <p class="text-sm text-gray-300 mb-2">{{ $meal->description }}</p>
                                                <div class="flex justify-between text-xs text-gray-400">
                                                    <span>{{ $meal->total_calories ?? 0 }} cal</span>
                                                    <span>
                                                        C: {{ $meal->carbs ?? 0 }}g • P: {{ $meal->protein ?? 0 }}g •
                                                        F: {{ $meal->fat ?? 0 }}g
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            @else
                                <div class="p-6 text-center">
                                    <div class="mb-3">
                                        <svg class="w-12 h-12 mx-auto text-gray-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M12 6v6l4 2m6-6a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h4 class="font-medium text-gray-300 mb-1">No meals logged today</h4>
                                    <p class="text-sm text-gray-500 mb-4">Start tracking your nutrition by adding your
                                        first meal</p>
                                    <button
                                        class="px-4 py-2 bg-olive-500 hover:bg-olive-600 text-white rounded-lg text-sm font-medium transition-colors">
                                        Log Your First Meal
                                    </button>
                                </div>
                            @endif
                        </div>
                    @else
                        {{-- Previous days - Show collapsed summary --}}
                        <div class="p-4">
                            @if ($dayData['meal_count'] > 0)
                                <button
                                    class="w-full flex items-center justify-between text-sm text-gray-400 hover:text-gray-300 group">
                                    <span>{{ $dayData['meal_count'] }}
                                        meal{{ $dayData['meal_count'] !== 1 ? 's' : '' }} logged</span>
                                    <svg class="w-4 h-4 transform transition-transform group-hover:scale-110"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            @else
                                <p class="text-sm text-gray-500 text-center">No meals logged</p>
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                {{-- Fallback if no days data --}}
                <div class="bg-gray-800 rounded-xl border border-gray-700 p-6 text-center">
                    <p class="text-gray-400">No meal history available</p>
                </div>
            @endforelse

            {{-- Load More Button --}}
            @if ($canLoadMore)
                <form action="{{ route('meals.history') }}" method="GET">
                    <div class="text-center py-6">
                        <input type="hidden" name="days" value="{{ $nextDays }}">
                        <button type="submit"
                            class="bg-olive-600 hover:bg-olive-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center space-x-2">
                            <span>Load More Days</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <p class="text-xs text-gray-500 mt-2">Showing {{ $days }} of {{ min($days + 3, 14) }}
                            days maximum</p>
                    </div>
                </form>
            @else
                {{-- No More Days Message --}}
                <div class="text-center py-6">
                    @if ($days >= 14)
                        <div class="bg-gray-800/50 rounded-lg border border-gray-700/50 p-4">
                            <svg class="w-8 h-8 mx-auto text-gray-500 mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm text-gray-400">You've reached the maximum history limit (2 weeks)</p>
                        </div>
                    @elseif($dailyMealData->where('has_data', true)->isEmpty())
                        <div
                            class="bg-gradient-to-r from-olive-500/20 to-green-500/20 rounded-xl border border-olive-400/30 p-6">
                            <div class="mb-3">
                                <svg class="w-16 h-16 mx-auto text-olive-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-100 mb-2">Welcome to Nutrition Tracking!</h3>
                            <p class="text-gray-300 mb-4 max-w-md mx-auto">
                                Start your healthy journey by logging your first meal. Track calories, macros, and build
                                better eating habits.
                            </p>
                            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                <button
                                    class="px-6 py-3 bg-olive-500 hover:bg-olive-600 text-white rounded-lg font-medium transition-colors">
                                    Log Your First Meal
                                </button>
                                <button
                                    class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-gray-200 rounded-lg font-medium transition-colors">
                                    Learn More
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-800/50 rounded-lg border border-gray-700/50 p-4">
                            <svg class="w-8 h-8 mx-auto text-gray-500 mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm text-gray-400">No more meal history to load</p>
                            <p class="text-xs text-gray-500 mt-1">This covers all your recorded meals</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
