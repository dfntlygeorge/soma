<x-app-layout>
    <x-slot name="title">Charmy the Marupok</x-slot>

    <div class="min-h-screen bg-gray-900 text-gray-100 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center gap-4 mb-4">
                    <a href="{{ route('dashboard') }}"
                        class="text-olive-400 hover:text-olive-300 font-medium transition-colors">
                        ← Back to Dashboard
                    </a>
                </div>
                <h1 class="text-3xl font-bold text-gray-100 mb-2">Charmy the Marupok</h1>
                <p class="text-gray-400">
                    Meal ideas for when you&apos;re too in love to think straight — but still tracking your macros. 💔🍚
                </p>
            </div>

            {{-- Step 1: Suggestion Options --}}
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                {{-- Option 1: From Previous Meals --}}
                <div
                    class="card bg-gray-800 shadow-xl border border-gray-700 hover:border-olive-500 transition-all duration-300 cursor-pointer group">
                    <div class="card-body p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <h2 class="card-title text-xl text-gray-100 group-hover:text-olive-400 transition-colors">
                                From Previous Meals
                            </h2>
                        </div>
                        <p class="text-gray-400 mb-4">
                            Rediscover meals you've logged before. Because sometimes the heart wants what it's already
                            had. 💕
                        </p>
                        <div class="card-actions justify-end">
                            <form method="POST" action="{{ route('charmy.history') }}">
                                @csrf
                                <button
                                    class="btn btn-outline border-olive-500 text-olive-400 hover:bg-olive-500 hover:text-gray-900">
                                    Browse Previous
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Option 2: AI Suggested --}}
                <div
                    class="card bg-gray-800 shadow-xl border border-gray-700 hover:border-olive-500 transition-all duration-300 cursor-pointer group">
                    <div class="card-body p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-3 h-3 bg-olive-500 rounded-full"></div>
                            <h2 class="card-title text-xl text-gray-100 group-hover:text-olive-400 transition-colors">
                                AI Suggested
                            </h2>
                        </div>
                        <p class="text-gray-400 mb-4">
                            Let AI cupid suggest meals based on your preferences and macro goals. Even robots understand
                            love. 🤖💘
                        </p>
                        <div class="card-actions justify-end">
                            <form method="POST" action="{{ route('charmy.ai') }}">
                                @csrf
                                <button type="submit"
                                    class="btn btn-outline border-olive-500 text-olive-400 hover:bg-olive-500 hover:text-gray-900">
                                    Get AI Ideas
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Step 2: Suggestion Results (Hidden by default, shown after selection) --}}
            <div class="mb-8" id="suggestions-results">
                <div class="flex items-center gap-3 mb-6">
                    <h2 class="text-2xl font-bold text-gray-100">Meal Suggestions</h2>
                    <div class="badge badge-outline border-olive-500 text-olive-400">3 ideas found</div>
                </div>

                <div class="grid gap-4 mb-6">
                    @if (!empty($suggestions) && count($suggestions) > 0)
                        @foreach ($suggestions as $suggestion)
                            @php
                                $isMatchThere = $suggestion['pantry_match'];
                                $match = $suggestion['pantry_match'] ?? 0;
                                $matchColor =
                                    $match >= 80 ? 'bg-green-500' : ($match >= 50 ? 'bg-yellow-500' : 'bg-red-500');
                            @endphp

                            <div class="card bg-gray-800 shadow-lg border border-gray-700">
                                <div class="card-body p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-xl font-semibold text-gray-100 mb-2">
                                                {{ $suggestion['name'] ?? 'From your previous meals' }}
                                            </h3>
                                            <p class="text-gray-400">
                                                {{ $suggestion['description'] ?? 'No description provided.' }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <div class="stat-value text-olive-400 text-lg">
                                                {{ $suggestion['calories'] ?? ($suggestion['total_calories'] ?? 'N/A') }}
                                            </div>
                                            <div class="stat-desc text-gray-500">calories</div>
                                        </div>
                                    </div>

                                    <div class="flex gap-4 mb-4">
                                        <div class="text-center">
                                            <div class="text-sm font-medium text-olive-400">
                                                {{ $suggestion['protein'] ?? 'N/A' }}g</div>
                                            <div class="text-xs text-gray-500">Protein</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-sm font-medium text-olive-400">
                                                {{ $suggestion['carbs'] ?? 'N/A' }}g</div>
                                            <div class="text-xs text-gray-500">Carbs</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-sm font-medium text-olive-400">
                                                {{ $suggestion['fat'] ?? 'N/A' }}g</div>
                                            <div class="text-xs text-gray-500">Fat</div>
                                        </div>
                                        <div class="flex-1"></div>
                                        @if ($isMatchThere)
                                            <div class="flex items-center gap-1">
                                                <div class="w-2 h-2 {{ $matchColor }} rounded-full"></div>
                                                <span class="text-xs text-gray-400">{{ $match }}% pantry
                                                    match</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="card-actions justify-end">
                                        <button
                                            class="btn btn-sm bg-olive-600 hover:bg-olive-700 text-gray-900 border-none">
                                            ✅ Plan This Meal
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

            </div>

            {{-- Step 3: Planned Meals Section --}}
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <h2 class="text-2xl font-bold text-gray-100">Your Planned Meals</h2>
                        {{-- <div class="badge badge-outline border-olive-500 text-olive-400">2 waiting</div> --}}
                    </div>
                    <button class="btn btn-sm btn-ghost text-olive-400 hover:bg-gray-800">
                        Clear All
                    </button>
                </div>

                <div class="space-y-4 hidden">
                    {{-- Planned Meal 1 --}}
                    <div class="card bg-gray-800 shadow-lg border border-gray-700 border-l-4 border-l-olive-500">
                        <div class="card-body p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <h3 class="text-lg font-semibold text-gray-100">Heartbreak Fried Rice</h3>
                                        <div class="badge badge-sm bg-olive-600 text-gray-900 border-none">Planned
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-400 mb-2">Added 2 hours ago</p>
                                    <p class="text-gray-400">Comfort food for when bae left you on read.</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-olive-400 font-semibold">420 cal</div>
                                    <div class="text-xs text-gray-500">25P • 45C • 18F</div>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <button
                                    class="btn btn-sm bg-olive-600 hover:bg-olive-700 text-gray-900 border-none flex-1">
                                    ✅ Log Instantly
                                </button>
                                <button
                                    class="btn btn-sm btn-outline border-olive-500 text-olive-400 hover:bg-olive-500 hover:text-gray-900 flex-1">
                                    ✏️ Edit & Log
                                </button>
                                <button class="btn btn-sm btn-ghost text-gray-400 hover:text-red-400">
                                    🗑️
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Planned Meal 2 --}}
                    <div class="card bg-gray-800 shadow-lg border border-gray-700 border-l-4 border-l-olive-500">
                        <div class="card-body p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <h3 class="text-lg font-semibold text-gray-100">Love Potion Smoothie</h3>
                                        <div class="badge badge-sm bg-olive-600 text-gray-900 border-none">Planned
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-400 mb-2">Added 1 day ago</p>
                                    <p class="text-gray-400">Berry smoothie that's sweeter than your crush's smile.</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-olive-400 font-semibold">285 cal</div>
                                    <div class="text-xs text-gray-500">28P • 35C • 4F</div>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <button
                                    class="btn btn-sm bg-olive-600 hover:bg-olive-700 text-gray-900 border-none flex-1">
                                    ✅ Log Instantly
                                </button>
                                <button
                                    class="btn btn-sm btn-outline border-olive-500 text-olive-400 hover:bg-olive-500 hover:text-gray-900 flex-1">
                                    ✏️ Edit & Log
                                </button>
                                <button class="btn btn-sm btn-ghost text-gray-400 hover:text-red-400">
                                    🗑️
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Empty State (when no planned meals) --}}
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">🍽️</div>
                    <h3 class="text-lg font-semibold text-gray-300 mb-2">No planned meals yet</h3>
                    <p class="text-gray-400 mb-6">Start by getting some meal suggestions above!</p>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="card bg-gray-800 shadow-lg border border-gray-700">
                <div class="card-body p-6">
                    <h3 class="text-lg font-semibold text-gray-100 mb-4">Quick Actions</h3>
                    <div class="flex flex-wrap gap-3">
                        <button
                            class="btn btn-sm btn-outline border-olive-500 text-olive-400 hover:bg-olive-500 hover:text-gray-900">
                            📝 Log Custom Meal
                        </button>
                        <button
                            class="btn btn-sm btn-outline border-olive-500 text-olive-400 hover:bg-olive-500 hover:text-gray-900">
                            🔄 Refresh Suggestions
                        </button>
                        <button
                            class="btn btn-sm btn-outline border-olive-500 text-olive-400 hover:bg-olive-500 hover:text-gray-900">
                            ⚙️ Preferences
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>


</x-app-layout>
