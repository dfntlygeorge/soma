{{-- resources/views/components/meals-section.blade.php --}}

<div class="mb-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-gray-100">Logged Meals</h2>
        <div class="text-sm text-gray-400">
            {{ count($meals ?? []) }} {{ Str::plural('meal', count($meals ?? [])) }} today
        </div>
    </div>

    {{-- Responsive grid optimized for compact space --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
        @forelse ($meals as $meal)
            <x-dashboard.meal-card :meal="$meal" />
        @empty
            <div class="col-span-full text-center py-12">
                <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a8.949 8.949 0 008.354-5.646z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-300 mb-2">No meals logged yet</h3>
                <p class="text-gray-500 text-sm mb-3">Start tracking your nutrition by adding your first meal above!</p>
                <div class="inline-flex items-center text-olive-400 text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    Track your progress
                </div>
            </div>
        @endforelse
    </div>

    {{-- Optional: Add a scrollable container for many meals --}}
    {{-- Uncomment if you want to limit height and add scrolling --}}
    {{-- 
    <div class="max-h-80 overflow-y-auto pr-2 scrollbar-thin scrollbar-track-gray-800 scrollbar-thumb-gray-600 hover:scrollbar-thumb-gray-500">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
            @forelse ($meals as $meal)
                <x-dashboard.meal-card :meal="$meal" />
            @empty
                // ... empty state code here
            @endforelse
        </div>
    </div>
    --}}
</div>
