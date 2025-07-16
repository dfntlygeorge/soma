{{-- resources/views/components/macro-card.blade.php --}}
@props(['macro'])

@php
    $percentage =
        $macro['daily_target'] > 0
            ? min(100, (($macro['daily_target'] - $macro['left']) / $macro['daily_target']) * 100)
            : 0;
    $strokeDasharray = 2 * 3.14159 * 45; // circumference for r=45
    $strokeDashoffset = $strokeDasharray - ($strokeDasharray * $percentage) / 100;
@endphp

<div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
    <div class="flex flex-col items-center">
        {{-- Circular Progress Bar --}}
        <div class="relative w-24 h-24 mb-4">
            <svg class="w-24 h-24 transform -rotate-90" viewBox="0 0 100 100">
                {{-- Background circle --}}
                <circle cx="50" cy="50" r="45" stroke="#f3f4f6" stroke-width="6" fill="none" />
                {{-- Progress circle --}}
                <circle cx="50" cy="50" r="45" stroke="{{ $macro['color'] ?? '#10b981' }}"
                    stroke-width="6" fill="none" stroke-dasharray="{{ $strokeDasharray }}"
                    stroke-dashoffset="{{ $strokeDashoffset }}" stroke-linecap="round"
                    class="transition-all duration-300 ease-in-out" />
            </svg>
            {{-- Percentage text --}}
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="text-sm font-bold text-gray-700">{{ round($percentage) }}%</span>
            </div>
        </div>

        {{-- Macro info --}}
        <div class="text-center">
            <div class="text-2xl font-bold text-gray-800 mb-1">
                {{ $macro['daily_target'] }} {{ $macro['unit'] }}
            </div>
            <div class="text-gray-600 font-medium mb-2">
                {{ $macro['label'] }}
            </div>
            <div class="text-sm text-gray-500 bg-gray-50 px-3 py-1 rounded-full">
                {{ $macro['left'] }} {{ $macro['unit'] }} left
            </div>
        </div>
    </div>
</div>
