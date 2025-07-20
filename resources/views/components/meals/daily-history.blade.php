@props(['dailyMealData', 'canLoadMore', 'nextDays', 'days'])

<div class="space-y-4 px-4 py-4">
    {{-- Daily Cards --}}
    @forelse($dailyMealData as $dayData)
        <x-meals.daily-card :dayData="$dayData" />
    @empty
        <div class="bg-gray-800 rounded-xl border border-gray-700 p-6 text-center">
            <p class="text-gray-400">No meal history available</p>
        </div>
    @endforelse

    {{-- Load More Section --}}
    <x-meals.load-more :canLoadMore="$canLoadMore" :nextDays="$nextDays" :days="$days" :dailyMealData="$dailyMealData" />
</div>
