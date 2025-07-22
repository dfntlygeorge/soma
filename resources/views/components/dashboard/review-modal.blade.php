{{-- resources/views/components/review-meal-modal.blade.php --}}

@if (session('review_macros'))
    @php
        $macros = session('review_macros');
        $description = session('review_description');
    @endphp

    <div id="review-modal" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex justify-center items-center z-50 p-4">
        <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-2xl w-full max-w-md transform transition-all">
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-olive-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 text-gray-100 rounded-lg focus:ring-2 focus:ring-olive-500 focus:border-olive-500 transition-colors"
                            required>

                            <option value="" disabled {{ old('meal_type') ? '' : 'selected' }}>Select
                                a meal type</option>

                            <option value="breakfast" {{ old('meal_type') === 'breakfast' ? 'selected' : '' }}>🌅
                                Breakfast
                            </option>
                            <option value="lunch" {{ old('meal_type') === 'lunch' ? 'selected' : '' }}>☀️
                                Lunch</option>
                            <option value="dinner" {{ old('meal_type') === 'dinner' ? 'selected' : '' }}>
                                🌙 Dinner</option>
                            <option value="snack" {{ old('meal_type') === 'snack' ? 'selected' : '' }}>🍎
                                Snack</option>
                        </select>
                        @error('meal_type')
                            <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                        @enderror
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
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
