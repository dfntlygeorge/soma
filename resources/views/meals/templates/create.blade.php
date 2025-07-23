<x-app-layout>
    <x-slot name="title">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Meal Template
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-900 text-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="max-w-2xl mx-auto">
                <!-- Header Section -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-100 mb-2">Create Meal Template</h1>
                    <p class="text-gray-400">Save this meal as a template for quick logging in the future</p>
                </div>

                <!-- Template Form -->
                <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
                    <form action="{{ route('meals.templates.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="meal_id" value="{{ $meal->id }}">

                        <!-- Template Name Input -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                                Template Name *
                            </label>
                            <input type="text" id="name" name="name"
                                value="{{ old('name', $meal->description) }}"
                                placeholder="Enter a memorable name for this meal template..."
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:border-transparent transition-colors"
                                required>
                            @error('name')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-400">
                                Choose a name that helps you identify this meal later (e.g., "Morning Protein Bowl",
                                "Post-Workout Snack")
                            </p>
                        </div>

                        <!-- Category Display -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Category
                            </label>
                            <div class="px-4 py-3 bg-gray-700 rounded-lg border border-gray-600">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-600 text-gray-900">
                                    {{ ucfirst($meal->category) }}
                                </span>
                            </div>
                        </div>

                        <!-- Meal Details Preview -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-200 mb-4">Nutritional Information</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <!-- Calories -->
                                <div class="bg-gray-700 rounded-lg p-4 border border-gray-600">
                                    <div class="flex items-center mb-2">
                                        <div class="w-3 h-3 bg-orange-500 rounded-full mr-2"></div>
                                        <span class="text-sm font-medium text-gray-300">Calories</span>
                                    </div>
                                    <p class="text-2xl font-bold text-gray-100">
                                        {{ number_format($meal->total_calories, 0) }}</p>
                                    <p class="text-sm text-gray-400">kcal</p>
                                </div>

                                <!-- Protein -->
                                <div class="bg-gray-700 rounded-lg p-4 border border-gray-600">
                                    <div class="flex items-center mb-2">
                                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                                        <span class="text-sm font-medium text-gray-300">Protein</span>
                                    </div>
                                    <p class="text-2xl font-bold text-gray-100">{{ number_format($meal->protein, 1) }}
                                    </p>
                                    <p class="text-sm text-gray-400">g</p>
                                </div>

                                <!-- Carbs -->
                                <div class="bg-gray-700 rounded-lg p-4 border border-gray-600">
                                    <div class="flex items-center mb-2">
                                        <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                        <span class="text-sm font-medium text-gray-300">Carbs</span>
                                    </div>
                                    <p class="text-2xl font-bold text-gray-100">{{ number_format($meal->carbs, 1) }}</p>
                                    <p class="text-sm text-gray-400">g</p>
                                </div>

                                <!-- Fat -->
                                <div class="bg-gray-700 rounded-lg p-4 border border-gray-600">
                                    <div class="flex items-center mb-2">
                                        <div class="w-3 h-3 bg-purple-500 rounded-full mr-2"></div>
                                        <span class="text-sm font-medium text-gray-300">Fat</span>
                                    </div>
                                    <p class="text-2xl font-bold text-gray-100">{{ number_format($meal->fat, 1) }}</p>
                                    <p class="text-sm text-gray-400">g</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-700">
                            <a href="{{ route('dashboard') }}"
                                class="px-6 py-3 bg-gray-600 hover:bg-gray-500 text-gray-100 font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-8 py-3 bg-yellow-600 hover:bg-yellow-500 text-gray-900 font-semibold rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-yellow-500 shadow-lg">
                                Create Template
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Help Text -->
                <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-yellow-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-gray-200">About Meal Templates</h4>
                            <p class="mt-1 text-sm text-gray-400">
                                Templates allow you to quickly log frequently eaten meals without having to add each
                                ingredient individually. Once created, you can find this template in your meal logging
                                options.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
