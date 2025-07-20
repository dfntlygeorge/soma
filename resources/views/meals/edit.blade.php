{{-- resources/views/meals/edit.blade.php --}}
<x-app-layout>
    <x-slot name="title">Edit Meal</x-slot>

    <div class="min-h-screen bg-gray-900 text-gray-100 py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center gap-4 mb-4">
                    <a href="{{ route('dashboard') }}" class="text-olive-400 hover:text-olive-300 font-medium">
                        ← Back to Dashboard
                    </a>
                </div>
                <h1 class="text-3xl font-bold text-gray-100">Edit Meal</h1>
                <p class="text-gray-400">Update your meal information</p>
            </div>

            {{-- Edit Form --}}
            <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-6">
                <form action="{{ route('meals.update', $meal->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        {{-- Description --}}
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-300 mb-2">
                                Description
                            </label>
                            <input type="text" id="description" name="description"
                                value="{{ old('description', $meal->description) }}"
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 text-gray-100 rounded-lg focus:ring-2 focus:ring-olive-500 focus:border-olive-500 placeholder-gray-400 transition-colors @error('description') border-red-500 @enderror"
                                required>
                            @error('description')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Meal Type/Category --}}
                        <div>
                            <label for="meal_type" class="block text-sm font-medium text-gray-300 mb-2">
                                Meal Type
                            </label>
                            <select name="meal_type" id="meal_type"
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 text-gray-100 rounded-lg focus:ring-2 focus:ring-olive-500 focus:border-olive-500 transition-colors @error('meal_type') border-red-500 @enderror">
                                <option value="breakfast"
                                    {{ old('meal_type', $meal->category) == 'breakfast' ? 'selected' : '' }}>🌅
                                    Breakfast</option>
                                <option value="lunch"
                                    {{ old('meal_type', $meal->category) == 'lunch' ? 'selected' : '' }}>☀️ Lunch
                                </option>
                                <option value="dinner"
                                    {{ old('meal_type', $meal->category) == 'dinner' ? 'selected' : '' }}>🌙 Dinner
                                </option>
                                <option value="snack"
                                    {{ old('meal_type', $meal->category) == 'snack' ? 'selected' : '' }}>🍎 Snack
                                </option>
                            </select>
                            @error('meal_type')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nutrition Info Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Calories --}}
                            <div>
                                <label for="total_calories" class="block text-sm font-medium text-gray-300 mb-2">
                                    Calories
                                </label>
                                <input type="number" id="total_calories" name="total_calories"
                                    value="{{ old('total_calories', $meal->total_calories) }}" min="0"
                                    step="0.1"
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 text-gray-100 rounded-lg focus:ring-2 focus:ring-olive-500 focus:border-olive-500 transition-colors @error('total_calories') border-red-500 @enderror"
                                    required>
                                @error('total_calories')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Protein --}}
                            <div>
                                <label for="protein" class="block text-sm font-medium text-gray-300 mb-2">
                                    Protein (g)
                                </label>
                                <input type="number" id="protein" name="protein"
                                    value="{{ old('protein', $meal->protein) }}" min="0" step="0.1"
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 text-gray-100 rounded-lg focus:ring-2 focus:ring-olive-500 focus:border-olive-500 transition-colors @error('protein') border-red-500 @enderror"
                                    required>
                                @error('protein')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Carbs --}}
                            <div>
                                <label for="carbs" class="block text-sm font-medium text-gray-300 mb-2">
                                    Carbohydrates (g)
                                </label>
                                <input type="number" id="carbs" name="carbs"
                                    value="{{ old('carbs', $meal->carbs) }}" min="0" step="0.1"
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 text-gray-100 rounded-lg focus:ring-2 focus:ring-olive-500 focus:border-olive-500 transition-colors @error('carbs') border-red-500 @enderror"
                                    required>
                                @error('carbs')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Fat --}}
                            <div>
                                <label for="fat" class="block text-sm font-medium text-gray-300 mb-2">
                                    Fat (g)
                                </label>
                                <input type="number" id="fat" name="fat"
                                    value="{{ old('fat', $meal->fat) }}" min="0" step="0.1"
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 text-gray-100 rounded-lg focus:ring-2 focus:ring-olive-500 focus:border-olive-500 transition-colors @error('fat') border-red-500 @enderror"
                                    required>
                                @error('fat')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Current Values Display --}}
                        <div class="bg-gray-700 border border-gray-600 rounded-lg p-4">
                            <h3 class="font-semibold text-gray-100 mb-3">Current Values</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="bg-gray-800 border border-gray-600 p-3 rounded">
                                    <span class="text-gray-400">Calories:</span>
                                    <span class="font-semibold text-olive-400">{{ $meal->total_calories }}</span>
                                </div>
                                <div class="bg-gray-800 border border-gray-600 p-3 rounded">
                                    <span class="text-gray-400">Protein:</span>
                                    <span class="font-semibold text-olive-400">{{ $meal->protein }}g</span>
                                </div>
                                <div class="bg-gray-800 border border-gray-600 p-3 rounded">
                                    <span class="text-gray-400">Carbs:</span>
                                    <span class="font-semibold text-olive-400">{{ $meal->carbs }}g</span>
                                </div>
                                <div class="bg-gray-800 border border-gray-600 p-3 rounded">
                                    <span class="text-gray-400">Fat:</span>
                                    <span class="font-semibold text-olive-400">{{ $meal->fat }}g</span>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-t border-gray-600">
                                <span class="text-gray-400">Current Category:</span>
                                <span class="font-semibold text-olive-300 capitalize">
                                    {{ $meal->category ?? 'Not set' }}
                                    @if ($meal->category)
                                        @switch($meal->category)
                                            @case('breakfast')
                                                🌅
                                            @break

                                            @case('lunch')
                                                ☀️
                                            @break

                                            @case('dinner')
                                                🌙
                                            @break

                                            @case('snack')
                                                🍎
                                            @break
                                        @endswitch
                                    @endif
                                </span>
                            </div>
                        </div>

                        {{-- Form Actions --}}
                        <div class="flex gap-4 pt-4">
                            <button type="submit"
                                class="flex-1 bg-olive-600 hover:bg-olive-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 transform hover:scale-105 focus:ring-2 focus:ring-olive-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                                Update Meal
                            </button>
                            <a href="{{ route('dashboard') }}"
                                class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium text-center transition-all duration-200 transform hover:scale-105 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
