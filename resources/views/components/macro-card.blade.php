{{-- resources/views/components/macro-card.blade.php --}}
@props(['macro'])

@php
    $consumed = $macro['daily_target'] - $macro['left'];
    $percentage = $macro['daily_target'] > 0 ? min(100, ($consumed / $macro['daily_target']) * 100) : 0;
    $strokeDasharray = 2 * 3.14159 * 42; // circumference for r=42 (slightly smaller for better proportions)
    $strokeDashoffset = $strokeDasharray - ($strokeDasharray * $percentage) / 100;

    // Determine status and colors
    $isOverTarget = $consumed > $macro['daily_target'];
    $isNearTarget = $percentage >= 85 && !$isOverTarget;

    // Dynamic colors based on macro type and status
    $progressColor = match ($macro['label']) {
        'Calories' => $isOverTarget ? '#ef4444' : ($isNearTarget ? '#f59e0b' : '#10b981'),
        'Protein' => $isOverTarget ? '#ef4444' : ($isNearTarget ? '#f59e0b' : '#3b82f6'),
        'Carbs' => $isOverTarget ? '#ef4444' : ($isNearTarget ? '#f59e0b' : '#22c55e'),
        'Fat' => $isOverTarget ? '#ef4444' : ($isNearTarget ? '#f59e0b' : '#8b5cf6'),
        default => '#10b981',
    };

    $iconColor = match ($macro['label']) {
        'Calories' => 'text-orange-400',
        'Protein' => 'text-blue-400',
        'Carbs' => 'text-green-400',
        'Fat' => 'text-purple-400',
        default => 'text-olive-400',
    };
@endphp

<div
    class="bg-gray-800 border border-gray-700 rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-200 hover:border-gray-600 hover:scale-105">
    <div class="flex flex-col items-center">
        {{-- Header with icon --}}
        <div class="flex items-center space-x-2 mb-4">
            <div class="w-8 h-8 bg-gray-700 rounded-lg flex items-center justify-center">
                @if ($macro['label'] === 'Calories')
                    <svg class="w-4 h-4 {{ $iconColor }}" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M13.5.67s.74 2.65.74 4.8c0 2.06-1.35 3.73-3.41 3.73-2.07 0-3.63-1.67-3.63-3.73l.03-.36C5.21 7.51 4 10.62 4 14c0 4.42 3.58 8 8 8s8-3.58 8-8C20 8.61 17.41 3.8 13.5.67zM11.71 19c-1.78 0-3.22-1.4-3.22-3.14 0-1.62 1.05-2.76 2.81-3.12 1.77-.36 3.6-1.21 4.62-2.58.39 1.29.59 2.65.59 4.04 0 2.65-2.15 4.8-4.8 4.8z" />
                    </svg>
                @elseif($macro['label'] === 'Protein')
                    <svg class="w-4 h-4 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                @elseif($macro['label'] === 'Carbs')
                    <svg class="w-4 h-4 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A2.701 2.701 0 003 15.546V8.454c.523 0 1.046-.151 1.5-.454a2.704 2.704 0 013 0 2.704 2.704 0 003 0 2.704 2.704 0 013 0 2.704 2.704 0 003 0 2.704 2.704 0 013 0c.454.303.977.454 1.5.454v7.092z" />
                    </svg>
                @else
                    <svg class="w-4 h-4 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                    </svg>
                @endif
            </div>
            <h3 class="text-sm font-semibold text-gray-200">{{ $macro['label'] }}</h3>
        </div>

        {{-- Circular Progress Bar --}}
        <div class="relative w-28 h-28 mb-4">
            <svg class="w-28 h-28 transform -rotate-90" viewBox="0 0 100 100">
                {{-- Background circle --}}
                <circle cx="50" cy="50" r="42" stroke="#374151" stroke-width="4" fill="none"
                    opacity="0.3" />
                {{-- Progress circle --}}
                <circle cx="50" cy="50" r="42" stroke="{{ $progressColor }}" stroke-width="4"
                    fill="none" stroke-dasharray="{{ $strokeDasharray }}" stroke-dashoffset="{{ $strokeDashoffset }}"
                    stroke-linecap="round" class="transition-all duration-500 ease-in-out drop-shadow-sm" />
            </svg>

            {{-- Center content --}}
            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span
                    class="text-lg font-bold {{ $isOverTarget ? 'text-red-400' : ($isNearTarget ? 'text-yellow-400' : 'text-olive-300') }}">
                    {{ round($percentage) }}%
                </span>
                <span class="text-xs text-gray-500 mt-1">complete</span>
            </div>
        </div>

        {{-- Macro statistics --}}
        <div class="text-center space-y-2 w-full">
            {{-- Current consumption --}}
            <div class="flex items-center justify-between bg-gray-700/30 rounded-lg px-3 py-2">
                <span class="text-xs text-gray-400">Consumed:</span>
                <span class="text-sm font-bold {{ $isOverTarget ? 'text-red-400' : 'text-olive-300' }}">
                    {{ $consumed }} {{ $macro['unit'] }}
                </span>
            </div>

            {{-- Target and remaining --}}
            <div class="flex items-center justify-between">
                <div class="text-center flex-1">
                    <div class="text-xs text-gray-500">Target</div>
                    <div class="text-sm font-semibold text-gray-300">{{ $macro['daily_target'] }} {{ $macro['unit'] }}
                    </div>
                </div>
                <div class="w-px h-8 bg-gray-600 mx-3"></div>
                <div class="text-center flex-1">
                    <div class="text-xs text-gray-500">{{ $macro['left'] > 0 ? 'Left' : 'Over' }}</div>
                    <div class="text-sm font-semibold {{ $macro['left'] > 0 ? 'text-gray-300' : 'text-red-400' }}">
                        {{ abs($macro['left']) }} {{ $macro['unit'] }}
                    </div>
                </div>
            </div>

            {{-- Status indicator --}}
            @if ($isOverTarget)
                <div class="bg-red-900/30 border border-red-600/30 rounded-lg px-2 py-1">
                    <span class="text-xs text-red-400 font-medium">⚠️ Over target</span>
                </div>
            @elseif($isNearTarget)
                <div class="bg-yellow-900/30 border border-yellow-600/30 rounded-lg px-2 py-1">
                    <span class="text-xs text-yellow-400 font-medium">🎯 Almost there!</span>
                </div>
            @elseif($percentage >= 50)
                <div class="bg-olive-900/30 border border-olive-600/30 rounded-lg px-2 py-1">
                    <span class="text-xs text-olive-400 font-medium">📈 Good progress</span>
                </div>
            @else
                <div class="bg-gray-700/30 border border-gray-600/30 rounded-lg px-2 py-1">
                    <span class="text-xs text-gray-400 font-medium">🚀 Let's go!</span>
                </div>
            @endif
        </div>
    </div>
</div>
