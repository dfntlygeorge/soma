{{-- components/dashboard/streaks.blade.php --}}
<div class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-6 mb-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-gray-100 flex items-center">
            <div
                class="w-8 h-8 bg-gradient-to-r from-orange-500 to-red-500 rounded-lg flex items-center justify-center mr-3">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12.76 3.76a6 6 0 0 1 8.48 8.48l-8.53 8.54a1 1 0 0 1-1.42 0l-8.53-8.54a6 6 0 0 1 8.48-8.48L12 4.5l.76-.74z" />
                </svg>
            </div>
            Streak Progress
        </h2>

        {{-- Current Streak Badge --}}
        <div
            class="bg-gradient-to-r from-olive-500 to-olive-600 text-white px-3 py-1 rounded-full text-sm font-semibold animate-pulse">
            🔥 14 Day Streak!
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        {{-- Current Streak --}}
        <div
            class="bg-gray-700/50 rounded-lg p-4 text-center border border-gray-600 hover:border-olive-500 transition-all duration-200 transform hover:scale-105">
            <div class="text-3xl font-bold text-olive-400 mb-1">14</div>
            <div class="text-sm text-gray-300 mb-2">Current Streak</div>
            <div class="flex items-center justify-center text-xs text-gray-400">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                </svg>
                Keep it up!
            </div>
        </div>

        {{-- Longest Streak --}}
        <div
            class="bg-gray-700/50 rounded-lg p-4 text-center border border-gray-600 hover:border-blue-500 transition-all duration-200 transform hover:scale-105">
            <div class="text-3xl font-bold text-blue-400 mb-1">28</div>
            <div class="text-sm text-gray-300 mb-2">Longest Streak</div>
            <div class="flex items-center justify-center text-xs text-gray-400">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                Personal Best
            </div>
        </div>

        {{-- Next Milestone --}}
        <div
            class="bg-gray-700/50 rounded-lg p-4 text-center border border-gray-600 hover:border-purple-500 transition-all duration-200 transform hover:scale-105">
            <div class="text-3xl font-bold text-purple-400 mb-1">7</div>
            <div class="text-sm text-gray-300 mb-2">Days to 21-Day Badge</div>
            <div class="w-full bg-gray-600 rounded-full h-2 mb-2">
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-2 rounded-full transition-all duration-500"
                    style="width: 67%"></div>
            </div>
            <div class="flex items-center justify-center text-xs text-gray-400">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M13 2.05v2.02c4.39.54 7.5 4.53 6.96 8.92-.39 3.16-2.58 5.8-5.6 6.78-5.18 1.68-10.53-2.06-10.53-7.28 0-3.11 2.56-5.63 5.67-5.63.31 0 .62.03.93.08V4.07C4.06 4.82 0 8.94 0 14s4.94 10 11 10 11-4.47 11-10S18.94 2.05 13 2.05z" />
                </svg>
                67% Complete
            </div>
        </div>
    </div>

    {{-- Achievement Badges Row --}}
    <div class="mt-6 pt-4 border-t border-gray-600">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-medium text-gray-300">Achievement Badges</span>
            <span class="text-xs text-gray-500">3 of 6 earned</span>
        </div>
        <div class="flex flex-wrap gap-2 justify-center md:justify-start">
            {{-- Earned badges --}}
            <div
                class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                🥉 7 Days
            </div>
            <div
                class="bg-gradient-to-r from-blue-500 to-cyan-600 text-white px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                🥈 14 Days
            </div>
            <div
                class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                🥇 21 Days
            </div>

            {{-- Locked badges --}}
            <div
                class="bg-gray-600 text-gray-400 px-3 py-1 rounded-full text-xs font-medium flex items-center opacity-50">
                🔒 30 Days
            </div>
            <div
                class="bg-gray-600 text-gray-400 px-3 py-1 rounded-full text-xs font-medium flex items-center opacity-50">
                🔒 60 Days
            </div>
            <div
                class="bg-gray-600 text-gray-400 px-3 py-1 rounded-full text-xs font-medium flex items-center opacity-50">
                🔒 100 Days
            </div>
        </div>
    </div>
</div>
