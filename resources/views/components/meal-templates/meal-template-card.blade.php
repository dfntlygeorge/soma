{{-- resources/views/components/meal-template-card.blade.php --}}
@props(['meal'])

<div class="bg-gray-800 rounded-lg border border-gray-700 p-4 hover:border-olive-400 transition-all duration-200">
    {{-- Header with name and dropdown --}}
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-lg font-semibold text-gray-100 truncate">{{ $meal->name }}</h3>

        {{-- Dropdown Menu --}}
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="p-1 rounded-full hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                </svg>
            </button>

            <div x-show="open" @click.away="open = false" x-transition
                class="absolute right-0 mt-2 w-48 bg-gray-700 rounded-md shadow-lg z-10 border border-gray-600">
                {{-- Edit Action --}}
                <a href="{{ route('meal-templates.edit', ['meal_template_id' => $meal->id]) }}"
                    class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-600 hover:text-white transition-colors duration-150">
                    <svg class="w-4 h-4 mr-3 text-olive-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Template
                </a>

                {{-- Delete Action --}}
                <form method="POST" action="{{ route('meal-templates.destroy', $meal->id) }}" class="block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this template?')"
                        class="flex items-center w-full px-4 py-2 text-sm text-gray-300 hover:bg-gray-600 hover:text-red-400 transition-colors duration-150">
                        <svg class="w-4 h-4 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete Template
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Category --}}
    @if ($meal->category)
        <div class="mb-3">
            <span
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-700 text-gray-300">
                {{ $meal->category }}
            </span>
        </div>
    @endif

    {{-- Macros Grid --}}
    <div class="grid grid-cols-4 gap-2 mb-4">
        {{-- Calories --}}
        <div class="text-center">
            <div class="text-xs text-gray-400 mb-1">CAL</div>
            <div class="text-lg font-bold text-olive-400">{{ $meal->calories }}</div>
        </div>

        {{-- Protein --}}
        <div class="text-center">
            <div class="text-xs text-gray-400 mb-1">PRO</div>
            <div class="text-lg font-bold text-blue-400">{{ $meal->protein }}g</div>
        </div>

        {{-- Carbs --}}
        <div class="text-center">
            <div class="text-xs text-gray-400 mb-1">CARB</div>
            <div class="text-lg font-bold text-red-400">{{ $meal->carbs }}g</div>
        </div>

        {{-- Fat --}}
        <div class="text-center">
            <div class="text-xs text-gray-400 mb-1">FAT</div>
            <div class="text-lg font-bold text-yellow-400">{{ $meal->fat }}g</div>
        </div>
    </div>

    {{-- Action Button --}}
    <button onclick="openModal('use-template-{{ $meal->id }}')"
        class="w-full bg-olive-600 hover:bg-olive-500 text-white font-medium py-2 px-4 rounded-md transition-colors duration-200">
        Use Template
    </button>
</div>

{{-- Use Template Modal --}}
{{-- props is $saved_meal --}}
<x-meal-templates.review-modal-template :modal-id="'use-template-' . $meal->id" title="Use Template: {{ $meal->name }}" :action-route="route('meals.confirm')"
    action-text="Log Meal" :description="$meal->name" :calories="$meal->calories" :protein="$meal->protein" :carbs="$meal->carbs" :fat="$meal->fat"
    :show-description-input="false" />
