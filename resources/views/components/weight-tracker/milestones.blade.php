{{-- resources/views/components/milestones.blade.php --}}

<!-- Milestones Section -->
<div class="bg-gray-800 rounded-xl p-6 border border-gray-700 mb-6">
    <h3 class="text-xl font-semibold text-white mb-4">Weight Loss Milestones</h3>
    <div class="grid grid-cols-3 md:grid-cols-6 lg:grid-cols-8 xl:grid-cols-10 gap-2">
        @foreach ($milestones as $milestone)
            @if ($milestone['status'] === 'achieved')
                <!-- Achieved Milestones -->
                <div class="flex flex-col items-center p-2 bg-green-900/30 border border-green-600/50 rounded-lg">
                    <div class="text-lg mb-0.5">{{ $milestone['icon'] }}</div>
                    <div class="text-xs font-semibold text-green-400 text-center leading-tight">{{ $milestone['label'] }}
                    </div>
                    <div class="text-[10px] text-gray-400 mt-0.5">{{ $milestone['display_date'] }}</div>
                </div>
            @elseif($milestone['status'] === 'next')
                <!-- Next Milestone -->
                <div
                    class="flex flex-col items-center p-2 bg-yellow-900/30 border border-yellow-600/50 rounded-lg animate-pulse">
                    <div class="text-lg mb-0.5">{{ $milestone['icon'] }}</div>
                    <div class="text-xs font-semibold text-yellow-400 text-center leading-tight">
                        {{ $milestone['label'] }}</div>
                    <div class="text-[10px] text-gray-400 mt-0.5">{{ $milestone['display_date'] }}</div>
                </div>
            @else
                <!-- Locked Milestones -->
                <div class="flex flex-col items-center p-2 bg-gray-700/30 border border-gray-600/50 rounded-lg">
                    <div class="text-lg mb-0.5">{{ $milestone['label'] === 'Goal Reached' ? $milestone['icon'] : '🔒' }}
                    </div>
                    <div class="text-xs font-semibold text-gray-400 text-center leading-tight">{{ $milestone['label'] }}
                    </div>
                    <div class="text-[10px] text-gray-500 mt-0.5">{{ $milestone['display_date'] }}</div>
                </div>
            @endif
        @endforeach
    </div>
</div>
