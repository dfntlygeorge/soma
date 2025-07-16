<x-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Today's Macros</h1>
                <p class="text-gray-600">Track your daily nutrition goals</p>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Macro target cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                @foreach ($daily_macros_target as $macro)
                    <x-macro-card :macro="$macro" />
                @endforeach
            </div>

            {{-- Add new meal section --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Log New Meal</h2>
                <form action="{{ route('meals.review') }}" method="POST" class="flex gap-4">
                    @csrf
                    <input type="text" name="description" placeholder="Example: 100g chicken, 1 cup rice"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        Log Meal
                    </button>
                </form>
            </div>

            {{-- Gemini response display --}}
            @if (!empty($macros))
                <div class="bg-green-50 border border-green-200 rounded-xl p-6 mb-8">
                    <h2 class="text-xl font-semibold text-green-800 mb-4">New Meal Analysis</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-green-700"><strong>Description:</strong>
                                {{ $macros['description'] ?? 'N/A' }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="bg-white p-3 rounded-lg">
                                <span class="text-green-600">Calories:</span> {{ $macros['total_calories'] ?? 'N/A' }}
                            </div>
                            <div class="bg-white p-3 rounded-lg">
                                <span class="text-green-600">Protein:</span> {{ $macros['protein'] ?? 'N/A' }}g
                            </div>
                            <div class="bg-white p-3 rounded-lg">
                                <span class="text-green-600">Carbs:</span> {{ $macros['carbs'] ?? 'N/A' }}g
                            </div>
                            <div class="bg-white p-3 rounded-lg">
                                <span class="text-green-600">Fat:</span> {{ $macros['fat'] ?? 'N/A' }}g
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Meals section --}}
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Logged Meals</h2>

                <div class="space-y-6">
                    @forelse ($meals as $meal)
                        <x-meal-card :meal="$meal" />
                    @empty
                        <div class="text-center py-12">
                            <div class="text-gray-400 text-6xl mb-4">🍽️</div>
                            <p class="text-gray-500 text-lg">No meals logged yet.</p>
                            <p class="text-gray-400">Start tracking your nutrition by adding your first meal above!</p>
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
                    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 p-4">
                    <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Review Your Meal</h2>

                            <form action="{{ route('meals.confirm') }}" method="POST">
                                @csrf

                                <div class="mb-4">
                                    <label class="block text-gray-700 font-medium mb-2">Description</label>
                                    <input type="text" name="description" value="{{ $macros['description'] }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>

                                <input type="hidden" name="total_calories" value="{{ $macros['total_calories'] }}">
                                <input type="hidden" name="protein" value="{{ $macros['protein'] }}">
                                <input type="hidden" name="carbs" value="{{ $macros['carbs'] }}">
                                <input type="hidden" name="fat" value="{{ $macros['fat'] }}">

                                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                    <h3 class="font-semibold text-gray-900 mb-3">Nutritional Information</h3>
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Calories:</span>
                                            <span class="font-semibold">{{ $macros['total_calories'] }}kcal</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Protein:</span>
                                            <span class="font-semibold">{{ $macros['protein'] }}g</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Carbs:</span>
                                            <span class="font-semibold">{{ $macros['carbs'] }}g</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Fat:</span>
                                            <span class="font-semibold">{{ $macros['fat'] }}g</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex gap-3">
                                    <button type="submit"
                                        class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                        Confirm & Save
                                    </button>
                                    <a href="{{ route('dashboard') }}"
                                        class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium text-center transition-colors">
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
</x-layout>
