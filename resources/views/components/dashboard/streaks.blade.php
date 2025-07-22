{{-- components/dashboard/streaks.blade.php --}}
<div class="bg-gray-800 border border-gray-700 rounded-lg shadow-lg p-4">
    {{-- Header Section --}}
    <div class="flex items-center justify-between mb-3">
        <div class="flex items-center">
            <div
                class="w-6 h-6 bg-gradient-to-r from-orange-500 to-red-500 rounded-md flex items-center justify-center mr-2">
                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12.76 3.76a6 6 0 0 1 8.48 8.48l-8.53 8.54a1 1 0 0 1-1.42 0l-8.53-8.54a6 6 0 0 1 8.48-8.48L12 4.5l.76-.74z" />
                </svg>
            </div>
            <h2 class="text-base font-semibold text-gray-100">Progress & Rank</h2>
        </div>
        <div
            class="bg-gradient-to-r from-olive-500 to-olive-600 text-white px-2 py-1 rounded-full text-xs font-semibold">
            🔥 {{ $streak }} Days
        </div>
    </div>

    {{-- Current Rank Display --}}
    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-lg p-3 mb-4 border border-indigo-500">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div
                    class="w-10 h-10 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-full flex items-center justify-center mr-3 shadow-lg p-1">
                    <img src="{{ asset('rank_' . strtolower($rankInfo['name']) . '.png') }}"
                        alt="{{ $rankInfo['name'] }} Rank" class="w-8 h-8 object-contain">

                </div>
                <div>
                    <div class="text-lg font-bold text-white">{{ $rankInfo['name'] }}</div>
                    <div class="text-xs text-indigo-200">{{ $rankInfo['description'] }}
                    </div>
                </div>
            </div>
            <div class="text-right group relative">
                <div class="text-sm font-semibold text-cyan-200 cursor-help">
                    {{ $user->exp }}{{ $rankNextInfo['next_threshold'] ? ' / ' . $rankNextInfo['next_threshold'] : '' }}
                    PP
                </div>
                <div class="text-xs text-indigo-300">
                    @if ($rankNextInfo['next_rank'])
                        {{ $rankNextInfo['exp_needed'] }} PP to {{ $rankNextInfo['next_rank'] }}
                    @else
                        Max rank achieved 💯
                    @endif
                </div>

                <!-- Tooltip -->
                <div
                    class="absolute right-0 -top-6 w-max px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    PP = Pogi Points 😎
                </div>
            </div>


        </div>

        {{-- Rank Progress Bar --}}
        <div class="mt-3">
            <div class="w-full bg-indigo-800/50 rounded-full h-2">
                <div class="bg-gradient-to-r from-cyan-400 to-blue-500 h-2 rounded-full transition-all duration-500 shadow-sm"
                    style="width: {{ $rankProgressPercent }}%"></div>
            </div>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-3 gap-3 mb-4">
        {{-- Current Streak --}}
        <div
            class="bg-gray-700/50 rounded-lg p-3 text-center border border-gray-600 hover:border-olive-500 transition-colors duration-200">
            <div class="text-xl font-bold text-olive-400">{{ $streak }}</div>
            <div class="text-xs text-gray-300">Current</div>
        </div>

        {{-- Longest Streak --}}
        <div
            class="bg-gray-700/50 rounded-lg p-3 text-center border border-gray-600 hover:border-blue-500 transition-colors duration-200">
            <div class="text-xl font-bold text-blue-400">{{ $longest_streak }}</div>
            <div class="text-xs text-gray-300">Best</div>
        </div>

        {{-- Next Milestone --}}
        @if ($nextMilestone)
            <div
                class="bg-gray-700/50 rounded-lg p-3 text-center border border-gray-600 hover:border-purple-500 transition-colors duration-200">
                <div class="text-xl font-bold text-purple-400">{{ $nextMilestone }}</div>
                <div class="text-xs text-gray-300">To {{ $nextMilestone }}-Day</div>
                <div class="w-full bg-gray-600 rounded-full h-1 mt-1">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-1 rounded-full transition-all duration-500"
                        style="width: {{ $milestoneProgress }}%"></div>
                </div>
            </div>
        @else
            <div
                class="bg-green-700/40 rounded-lg p-3 text-center border border-green-500 transition-colors duration-200">
                <div class="text-xl font-bold text-green-300">🎉</div>
                <div class="text-xs text-green-100">All milestones unlocked!</div>
            </div>
        @endif

    </div>

    {{-- Achievement Badges --}}
    <div class="border-t border-gray-600 pt-3">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-medium text-gray-300">Achievements</span>
            <span class="text-xs text-gray-500">{{ count($earned) }}/{{ count($milestones) }}</span>
        </div>

        <div class="flex flex-wrap gap-1.5">
            @foreach ($milestones as $day => $badge)
                @php
                    $key = "{$day}_day";
                    $isUnlocked = in_array($key, $earned);
                    $baseClass = 'px-2 py-0.5 rounded-full text-xs font-medium flex items-center';
                @endphp

                @if ($isUnlocked)
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white {{ $baseClass }}">
                        {{ $badge['emoji'] }} {{ $badge['label'] }}
                    </div>
                @else
                    <div class="bg-gray-600 text-gray-400 opacity-60 {{ $baseClass }}">
                        🔒 {{ $badge['label'] }}
                    </div>
                @endif
            @endforeach
        </div>
    </div>

</div>
