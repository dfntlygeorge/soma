{{-- resources/views/components/meal-card.blade.php --}}
@props(['meal'])

<div
    class="bg-gray-800 border border-gray-700 rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-200 hover:border-gray-600">
    <div class="flex justify-between items-start mb-4">
        <div class="flex-1">
            <div class="flex items-center space-x-3 mb-2">
                <div
                    class="w-3 h-3 {{ match ($meal->category ?? 'snack') {
                        'breakfast' => 'bg-orange-400',
                        'lunch' => 'bg-green-400',
                        'dinner' => 'bg-purple-400',
                        'snack' => 'bg-pink-400',
                        default => 'bg-olive-400',
                    } }} rounded-full">
                </div>
                <span class="text-sm font-medium text-gray-300 capitalize">
                    {{ $meal->category ?? 'Meal' }}
                </span>
                <span class="text-xs text-gray-500">
                    {{ $meal->created_at->format('g:i A') }}
                </span>
            </div>
            <h3 class="text-lg font-semibold text-gray-100 mb-1 leading-tight">{{ $meal->description }}</h3>
            <span class="text-sm text-gray-400">{{ $meal->date->format('M d, Y') }}</span>
        </div>

        <div class="flex gap-2 ml-4">
            {{-- Edit button --}}
            <a href="{{ route('meals.edit', $meal->id) }}"
                class="inline-flex items-center px-3 py-2 bg-olive-600 hover:bg-olive-700 text-white text-sm font-medium rounded-lg transition-all duration-200 transform hover:scale-105 focus:ring-2 focus:ring-olive-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>

            {{-- Delete button --}}
            <form action="{{ route('meals.destroy', $meal->id) }}" method="POST" class="inline"
                onsubmit="return confirm('Are you sure you want to delete this meal?');">
                @method('DELETE')
                @csrf
                <button type="submit"
                    class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-all duration-200 transform hover:scale-105 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete
                </button>
            </form>
        </div>
    </div>

    {{-- Nutrition info section --}}
    <div class="bg-gray-700/30 rounded-lg p-4">
        <div class="flex items-center justify-between mb-3">
            <h4 class="text-sm font-medium text-gray-300 flex items-center">
                <svg class="w-4 h-4 mr-2 text-olive-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Nutritional Information
            </h4>
            <div class="text-lg font-bold text-olive-300">{{ $meal->total_calories }} kcal</div>
        </div>

        {{-- Macros breakdown --}}
        <div class="grid grid-cols-3 gap-3">
            <div class="bg-gray-800/60 rounded-lg p-3 text-center border border-gray-600/50">
                <div class="text-xs text-gray-400 uppercase tracking-wide mb-1">Protein</div>
                <div class="text-lg font-bold text-blue-400">{{ $meal->protein }}</div>
                <div class="text-xs text-gray-500">grams</div>
            </div>
            <div class="bg-gray-800/60 rounded-lg p-3 text-center border border-gray-600/50">
                <div class="text-xs text-gray-400 uppercase tracking-wide mb-1">Carbs</div>
                <div class="text-lg font-bold text-green-400">{{ $meal->carbs }}</div>
                <div class="text-xs text-gray-500">grams</div>
            </div>
            <div class="bg-gray-800/60 rounded-lg p-3 text-center border border-gray-600/50">
                <div class="text-xs text-gray-400 uppercase tracking-wide mb-1">Fat</div>
                <div class="text-lg font-bold text-purple-400">{{ $meal->fat }}</div>
                <div class="text-xs text-gray-500">grams</div>
            </div>
        </div>

        {{-- Quick summary line like your existing pattern --}}
        <div class="mt-3 pt-3 border-t border-gray-600/30">
            <div class="flex justify-between text-xs text-gray-400">
                <span class="font-medium">{{ $meal->total_calories ?? 0 }} kcal total</span>
                <span>
                    C: {{ $meal->carbs ?? 0 }}g • P: {{ $meal->protein ?? 0 }}g • F: {{ $meal->fat ?? 0 }}g
                </span>
            </div>
        </div>
    </div>
</div>
