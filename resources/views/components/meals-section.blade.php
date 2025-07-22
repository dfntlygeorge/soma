{{-- resources/views/components/meals-section.blade.php --}}

<div class="mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-100">Logged Meals</h2>
        <div class="text-sm text-gray-400">
            {{ count($meals ?? []) }} {{ Str::plural('meal', count($meals ?? [])) }} today
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse ($meals as $meal)
            <x-dashboard.meal-card :meal="$meal" />
        @empty
            <div class="col-span-full text-center py-16">
                <div class="w-24 h-24 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a8.949 8.949 0 008.354-5.646z" />
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-300 mb-2">No meals logged yet</h3>
                <p class="text-gray-500 mb-4">Start tracking your nutrition by adding your first meal above!
                </p>
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
</div>
