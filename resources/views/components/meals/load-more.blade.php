@props(['canLoadMore', 'nextDays', 'days', 'dailyMealData'])

@if ($canLoadMore)
    <form action="{{ route('meals.history.index') }}" method="GET">
        <div class="text-center py-6">
            <input type="hidden" name="days" value="{{ $nextDays }}">
            <button type="submit"
                class="bg-olive-600 hover:bg-olive-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center space-x-2">
                <span>Load More Days</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
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
            <div class="bg-gradient-to-r from-olive-500/20 to-green-500/20 rounded-xl border border-olive-400/30 p-6">
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
