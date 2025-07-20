@props(['dayData'])

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

    <!-- Meals Content For today only -->
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
                                <span class="font-medium text-gray-200 capitalize">{{ $category }}</span>
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
                        <svg class="w-12 h-12 mx-auto text-gray-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
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
                    <svg class="w-4 h-4 transform transition-transform group-hover:scale-110" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            @else
                <p class="text-sm text-gray-500 text-center">No meals logged</p>
            @endif
        </div>
    @endif
</div>
