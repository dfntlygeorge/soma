{{-- resources/views/components/macro-card.blade.php --}}
@props(['macro'])

@php
    $consumed = $macro['daily_target'] - $macro['left'];
    $percentage = $macro['daily_target'] > 0 ? min(100, ($consumed / $macro['daily_target']) * 100) : 0;
    $strokeDasharray = 2 * 3.14159 * 28; // smaller radius for compact design
    $strokeDashoffset = $strokeDasharray - ($strokeDasharray * $percentage) / 100;

    $isOverTarget = $consumed > $macro['daily_target'];
    $isNearTarget = $percentage >= 85 && !$isOverTarget;
    $isCalorieCard = $macro['label'] === 'Calories';

    // Simplified color scheme
    $progressColor = match ($macro['label']) {
        'Calories' => $isOverTarget ? '#ef4444' : ($isNearTarget ? '#f59e0b' : '#10b981'),
        'Protein' => $isNearTarget ? '#f59e0b' : '#3b82f6',
        'Carbs' => $isNearTarget ? '#f59e0b' : '#22c55e',
        'Fat' => $isNearTarget ? '#f59e0b' : '#8b5cf6',
        default => '#10b981',
    };

    $iconColor = match ($macro['label']) {
        'Calories' => 'text-orange-400',
        'Protein' => 'text-blue-400',
        'Carbs' => 'text-green-400',
        'Fat' => 'text-purple-400',
        default => 'text-gray-400',
    };

    // Status for compact display
    $statusIcon = match (true) {
        $isOverTarget && $isCalorieCard => '⚠️',
        $percentage == 100 => '✅',
        $isNearTarget => '🎯',
        $percentage >= 50 => '📈',
        default => '🚀',
    };
@endphp

<div
    class="bg-gray-800 border border-gray-700 rounded-lg p-4 shadow-lg hover:shadow-xl transition-all duration-200 hover:border-gray-600 hover:scale-102 h-full">
    <div class="flex items-center justify-between mb-3">
        {{-- Header --}}
        <div class="flex items-center space-x-2">
            <div class="w-6 h-6 bg-gray-700 rounded-md flex items-center justify-center">
                @if ($macro['label'] === 'Calories')
                    <svg class="w-3 h-3 {{ $iconColor }}" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M13.5.67s.74 2.65.74 4.8c0 2.06-1.35 3.73-3.41 3.73-2.07 0-3.63-1.67-3.63-3.73l.03-.36C5.21 7.51 4 10.62 4 14c0 4.42 3.58 8 8 8s8-3.58 8-8C20 8.61 17.41 3.8 13.5.67z" />
                    </svg>
                @elseif($macro['label'] === 'Protein')
                    <svg class="w-3 h-3 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                @elseif($macro['label'] === 'Carbs')
                    <svg class="w-3 h-3 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A2.701 2.701 0 003 15.546V8.454c.523 0 1.046-.151 1.5-.454a2.704 2.704 0 013 0 2.704 2.704 0 003 0 2.704 2.704 0 013 0 2.704 2.704 0 003 0 2.704 2.704 0 013 0c.454.303.977.454 1.5.454v7.092z" />
                    </svg>
                @else
                    <svg class="w-3 h-3 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                    </svg>
                @endif
            </div>
            <h3 class="text-xs font-semibold text-gray-200">{{ $macro['label'] }}</h3>
        </div>

        {{-- Status indicator --}}
        <span class="text-sm">{{ $statusIcon }}</span>
    </div>

    <div class="flex items-center space-x-4">
        {{-- Compact Circular Progress --}}
        <div class="relative w-16 h-16 flex-shrink-0">
            <svg class="w-16 h-16 transform -rotate-90" viewBox="0 0 64 64">
                <circle cx="32" cy="32" r="28" stroke="#374151" stroke-width="3" fill="none"
                    opacity="0.3" />
                <circle cx="32" cy="32" r="28" stroke="{{ $progressColor }}" stroke-width="3"
                    fill="none" stroke-dasharray="{{ $strokeDasharray }}" stroke-dashoffset="{{ $strokeDashoffset }}"
                    stroke-linecap="round" class="transition-all duration-500 ease-in-out" />
            </svg>
            <div class="absolute inset-0 flex items-center justify-center">
                <span
                    class="text-sm font-bold {{ $isOverTarget && $isCalorieCard ? 'text-red-400' : 'text-gray-300' }}">
                    {{ round($percentage) }}%
                </span>
            </div>
        </div>

        {{-- Compact Stats --}}
        <div class="flex-1 space-y-1">
            <div class="flex justify-between items-center">
                <span class="text-xs text-gray-500">Consumed</span>
                <span
                    class="text-sm font-semibold {{ $isOverTarget && $isCalorieCard ? 'text-red-400' : 'text-gray-300' }}">
                    {{ $consumed }}{{ $macro['unit'] }}
                </span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-xs text-gray-500">Target</span>
                <span
                    class="text-sm font-medium text-gray-400">{{ $macro['daily_target'] }}{{ $macro['unit'] }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-xs text-gray-500">{{ $macro['left'] > 0 ? 'Left' : 'Over' }}</span>
                <span
                    class="text-sm font-medium {{ $macro['left'] < 0 && $isCalorieCard ? 'text-red-400' : 'text-gray-400' }}">
                    {{ abs($macro['left']) }}{{ $macro['unit'] }}
                </span>
            </div>
        </div>
    </div>
</div>
