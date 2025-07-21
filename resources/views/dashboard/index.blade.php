<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="min-h-screen bg-gray-900 text-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-100 mb-2">Today's Macros</h1>
                    <p class="text-gray-400">Track your daily nutrition goals</p>
                </div>
                <button class="flex items-center gap-2 text-olive-400 hover:text-olive-300 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                    </svg>
                    <span class="text-sm font-medium">Adjust Goals</span>
                </button>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div
                    class="bg-olive-900/50 border border-olive-600 text-olive-200 px-4 py-3 rounded-lg mb-6 backdrop-blur-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-olive-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- Macro target cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                @foreach ($daily_macros_target as $macro)
                    <x-dashboard.macro-card :macro="$macro" />
                @endforeach
            </div>

            {{-- Meal Logging Component --}}
            <x-dashboard.meal-logger />

            {{-- Gemini response display --}}
            @if (!empty($macros))
                <div
                    class="bg-gradient-to-r from-olive-900/30 to-olive-800/30 border border-olive-600/50 rounded-xl p-6 mb-8 backdrop-blur-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-olive-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-olive-200">New Meal Analysis</h2>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-gray-800/50 rounded-lg p-4">
                            <p class="text-olive-200">
                                <span class="font-medium text-olive-100">Description:</span>
                                <span class="ml-2">{{ $macros['description'] ?? 'N/A' }}</span>
                            </p>
                        </div>

                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                            <div class="bg-gray-800/50 p-4 rounded-lg text-center">
                                <div class="text-2xl font-bold text-olive-300">{{ $macros['total_calories'] ?? 'N/A' }}
                                </div>
                                <div class="text-sm text-gray-400">Calories</div>
                            </div>
                            <div class="bg-gray-800/50 p-4 rounded-lg text-center">
                                <div class="text-2xl font-bold text-olive-300">{{ $macros['protein'] ?? 'N/A' }}g</div>
                                <div class="text-sm text-gray-400">Protein</div>
                            </div>
                            <div class="bg-gray-800/50 p-4 rounded-lg text-center">
                                <div class="text-2xl font-bold text-olive-300">{{ $macros['carbs'] ?? 'N/A' }}g</div>
                                <div class="text-sm text-gray-400">Carbs</div>
                            </div>
                            <div class="bg-gray-800/50 p-4 rounded-lg text-center">
                                <div class="text-2xl font-bold text-olive-300">{{ $macros['fat'] ?? 'N/A' }}g</div>
                                <div class="text-sm text-gray-400">Fat</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Meals section --}}
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold text-gray-100">Logged Meals</h2>
                    <div class="text-sm text-gray-400">
                        {{ count($meals ?? []) }} {{ Str::plural('meal', count($meals ?? [])) }} today
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @forelse ($meals as $meal)
                        <x-dashboard.meal-card :meal="$meal" />
                    @empty
                        <div class="col-span-full text-center py-16">
                            <div
                                class="w-24 h-24 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a8.949 8.949 0 008.354-5.646z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-medium text-gray-300 mb-2">No meals logged yet</h3>
                            <p class="text-gray-500 mb-4">Start tracking your nutrition by adding your first meal above!
                            </p>
                            <div class="inline-flex items-center text-olive-400 text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                Track your progress
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Review Modal --}}
            @if (session('review_macros'))
                @php
                    $macros = session('review_macros');
                    $description = session('review_description');
                @endphp

                <div id="review-modal"
                    class="fixed inset-0 bg-black/70 backdrop-blur-sm flex justify-center items-center z-50 p-4">
                    <div
                        class="bg-gray-800 border border-gray-700 rounded-xl shadow-2xl w-full max-w-md transform transition-all">
                        <div class="p-6">
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 bg-olive-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-100">Review Your Meal</h2>
                            </div>

                            <form action="{{ route('meals.confirm') }}" method="POST" class="space-y-4">
                                @csrf

                                <div>
                                    <label class="block text-gray-300 font-medium mb-2">Description</label>
                                    <input type="text" name="description" value="{{ $macros['description'] }}"
                                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 text-gray-100 rounded-lg focus:ring-2 focus:ring-olive-500 focus:border-olive-500 transition-colors">
                                </div>

                                <div>
                                    <label class="block text-gray-300 font-medium mb-2">Meal Type</label>
                                    <select name="meal_type"
                                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 text-gray-100 rounded-lg focus:ring-2 focus:ring-olive-500 focus:border-olive-500 transition-colors">
                                        <option value="breakfast">🌅 Breakfast</option>
                                        <option value="lunch">☀️ Lunch</option>
                                        <option value="dinner">🌙 Dinner</option>
                                        <option value="snack">🍎 Snack</option>
                                    </select>
                                </div>

                                <input type="hidden" name="total_calories" value="{{ $macros['total_calories'] }}">
                                <input type="hidden" name="protein" value="{{ $macros['protein'] }}">
                                <input type="hidden" name="carbs" value="{{ $macros['carbs'] }}">
                                <input type="hidden" name="fat" value="{{ $macros['fat'] }}">

                                <div class="bg-gray-700/50 rounded-lg p-4">
                                    <h3 class="font-semibold text-gray-200 mb-3 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-olive-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                        Nutritional Information
                                    </h3>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="bg-gray-800 p-3 rounded-lg">
                                            <div class="text-xs text-gray-400 uppercase tracking-wide">Calories</div>
                                            <div class="text-lg font-bold text-olive-300">
                                                {{ $macros['total_calories'] }}kcal</div>
                                        </div>
                                        <div class="bg-gray-800 p-3 rounded-lg">
                                            <div class="text-xs text-gray-400 uppercase tracking-wide">Protein</div>
                                            <div class="text-lg font-bold text-olive-300">{{ $macros['protein'] }}g
                                            </div>
                                        </div>
                                        <div class="bg-gray-800 p-3 rounded-lg">
                                            <div class="text-xs text-gray-400 uppercase tracking-wide">Carbs</div>
                                            <div class="text-lg font-bold text-olive-300">{{ $macros['carbs'] }}g
                                            </div>
                                        </div>
                                        <div class="bg-gray-800 p-3 rounded-lg">
                                            <div class="text-xs text-gray-400 uppercase tracking-wide">Fat</div>
                                            <div class="text-lg font-bold text-olive-300">{{ $macros['fat'] }}g</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex gap-3 pt-4">
                                    <button type="submit"
                                        class="flex-1 bg-olive-600 hover:bg-olive-700 text-white px-4 py-3 rounded-lg font-medium transition-all duration-200 transform hover:scale-105 focus:ring-2 focus:ring-olive-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                                        <span class="flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Confirm & Save
                                        </span>
                                    </button>
                                    <a href="{{ route('dashboard') }}"
                                        class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-4 py-3 rounded-lg font-medium text-center transition-all duration-200 transform hover:scale-105 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
