{{-- resources/views/meals/edit.blade.php --}}
<x-app-layout>
    <x-slot name="title">Edit Meal</x-slot>

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center gap-4 mb-4">
                    <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                        ← Back to Dashboard
                    </a>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Meal</h1>
                <p class="text-gray-600">Update your meal information</p>
            </div>

            {{-- Edit Form --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <form action="{{ route('meals.update', $meal->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        {{-- Description --}}
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description
                            </label>
                            <input type="text" id="description" name="description"
                                value="{{ old('description', $meal->description) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                                required>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nutrition Info Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Calories --}}
                            <div>
                                <label for="total_calories" class="block text-sm font-medium text-gray-700 mb-2">
                                    Calories
                                </label>
                                <input type="number" id="total_calories" name="total_calories"
                                    value="{{ old('total_calories', $meal->total_calories) }}" min="0"
                                    step="0.1"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('total_calories') border-red-500 @enderror"
                                    required>
                                @error('total_calories')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Protein --}}
                            <div>
                                <label for="protein" class="block text-sm font-medium text-gray-700 mb-2">
                                    Protein (g)
                                </label>
                                <input type="number" id="protein" name="protein"
                                    value="{{ old('protein', $meal->protein) }}" min="0" step="0.1"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('protein') border-red-500 @enderror"
                                    required>
                                @error('protein')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Carbs --}}
                            <div>
                                <label for="carbs" class="block text-sm font-medium text-gray-700 mb-2">
                                    Carbohydrates (g)
                                </label>
                                <input type="number" id="carbs" name="carbs"
                                    value="{{ old('carbs', $meal->carbs) }}" min="0" step="0.1"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('carbs') border-red-500 @enderror"
                                    required>
                                @error('carbs')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Fat --}}
                            <div>
                                <label for="fat" class="block text-sm font-medium text-gray-700 mb-2">
                                    Fat (g)
                                </label>
                                <input type="number" id="fat" name="fat"
                                    value="{{ old('fat', $meal->fat) }}" min="0" step="0.1"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('fat') border-red-500 @enderror"
                                    required>
                                @error('fat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Current Values Display --}}
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="font-semibold text-gray-900 mb-3">Current Values</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="bg-white p-3 rounded">
                                    <span class="text-gray-600">Calories:</span>
                                    <span class="font-semibold">{{ $meal->total_calories }}</span>
                                </div>
                                <div class="bg-white p-3 rounded">
                                    <span class="text-gray-600">Protein:</span>
                                    <span class="font-semibold">{{ $meal->protein }}g</span>
                                </div>
                                <div class="bg-white p-3 rounded">
                                    <span class="text-gray-600">Carbs:</span>
                                    <span class="font-semibold">{{ $meal->carbs }}g</span>
                                </div>
                                <div class="bg-white p-3 rounded">
                                    <span class="text-gray-600">Fat:</span>
                                    <span class="font-semibold">{{ $meal->fat }}g</span>
                                </div>
                            </div>
                        </div>

                        {{-- Form Actions --}}
                        <div class="flex gap-4 pt-4">
                            <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                                Update Meal
                            </button>
                            <a href="{{ route('dashboard') }}"
                                class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium text-center transition-colors">
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
