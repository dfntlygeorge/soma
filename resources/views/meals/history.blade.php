<x-app-layout>
    <div class="bg-gray-900 text-gray-100 min-h-screen">
        {{-- Header --}}
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

        {{-- Weekly Summary Component --}}
        <x-meals.weekly-summary :weekRange="$weekRange" :averageCalories="$averageCalories" :averageProtein="$averageProtein" :chart="$chart" />

        {{-- Daily History Section Component --}}
        <x-meals.daily-history :dailyMealData="$dailyMealData" :canLoadMore="$canLoadMore" :nextDays="$nextDays" :days="$days" />
    </div>
</x-app-layout>
