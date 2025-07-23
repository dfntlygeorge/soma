@props([
    'weekRange',
    'averageCalories',
    'averageProtein',
    'chart',
    'weekOffset' => 0,
    'canGoToPreviousWeek' => false,
    'canGoToNextWeek' => false,
])

{{-- @php
    dd($canGoToNextWeek);
@endphp --}}

<div class="py-4 space-y-6">
    <div class="bg-gray-800 rounded-xl p-5 border border-gray-700">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-medium text-gray-100">
                @if ($weekOffset === 0)
                    This Week
                @elseif($weekOffset === -1)
                    Last Week
                @else
                    {{ abs($weekOffset) }} Weeks Ago
                @endif
            </h2>

            <!-- Week Navigation -->
            <div class="flex items-center gap-3">
                <!-- Previous Week Button: ThIS WORKS DONT TOUCH IT -->
                <a href="{{ request()->fullUrlWithQuery(['week' => $weekOffset - 1]) }}"
                    class="btn btn-ghost btn-sm {{ !$canGoToPreviousWeek ? 'btn-disabled' : '' }}"
                    @if (!$canGoToPreviousWeek) disabled @endif>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </a>

                <!-- Week Range -->
                <span class="text-sm text-gray-400 min-w-0">{{ $weekRange }}</span>
                @php
                    $disableNext = !$canGoToNextWeek || $weekOffset >= 0;
                    // context, current week = 0, last week = -1, and so on
                @endphp

                <!-- Next Week Button: FIXED - was !$disableNext, now $disableNext -->
                <a href="{{ request()->fullUrlWithQuery(['week' => $weekOffset + 1]) }}"
                    class="btn btn-ghost btn-sm {{ $disableNext ? 'opacity-50 pointer-events-none cursor-not-allowed' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Weekly Stats Grid -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div class="bg-gray-700/50 rounded-lg p-3">
                <div class="text-2xl font-bold text-olive-400">{{ $averageCalories }}kcal</div>
                <div class="text-sm text-gray-400">Avg Calories/day</div>
            </div>
            <div class="bg-gray-700/50 rounded-lg p-3">
                <div class="text-2xl font-bold text-blue-400">{{ $averageProtein }}g</div>
                <div class="text-sm text-gray-400">Avg Protein/day</div>
            </div>
        </div>

        <!-- Weekly Chart -->
        <div class="bg-gray-700/30 rounded-lg p-4">
            <h3 class="text-sm font-medium text-gray-300 mb-3">Daily Calories This Week</h3>
            <div style="height: 200px;">
                <x-chartjs-component :chart="$chart" />
            </div>
        </div>
    </div>
</div>
