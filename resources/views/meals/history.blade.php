<x-app-layout>
    <x-slot name='title'>Meal History</x-slot>
    <div class="min-h-screen bg-gray-900 text-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-100 mb-2">Meal History</h1>
                        <p class="text-gray-400">I remember it all too well... every meal I logged while waiting for your
                            reply.</p>
                    </div>
                    <div class="text-olive-400">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                        </svg>
                    </div>
                </div>
            </div>
            {{-- Weekly Summary Component --}}
            <x-meals.weekly-summary :weekRange="$weekRange" :averageCalories="$averageCalories" :averageProtein="$averageProtein" :chart="$chart"
                :canGoToPreviousWeek="$canGoToPreviousWeek" :canGoToNextWeek="$canGoToNextWeek" :weekOffset="$weekOffset" />

            {{-- Daily History Section Component --}}
            <x-meals.daily-history :dailyMealData="$dailyMealData" :canLoadMore="$canLoadMore" :nextDays="$nextDays" :days="$days" />
        </div>
    </div>
</x-app-layout>
