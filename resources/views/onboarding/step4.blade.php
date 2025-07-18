<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-base-200">
        <div class="card w-full max-w-md bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-center justify-center mb-6">Nutrition Targets</h2>

                <!-- Progress indicator -->
                <div class="mb-6">
                    <div class="flex justify-between text-sm text-base-content/60 mb-2">
                        <span>Step 4 of 5</span>
                        <span>Macro Targets</span>
                    </div>
                    <progress class="progress progress-primary w-full" value="80" max="100"></progress>
                </div>

                <div class="alert alert-info mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="stroke-current shrink-0 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm">These are suggested targets based on your profile. You can adjust them
                        later.</span>
                </div>

                <form method="POST" action="{{ route('onboarding.store') }}">
                    @csrf
                    <input type="hidden" name="step" value="4">

                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text">Daily Calories</span>
                        </label>
                        <input type="number" name="daily_calorie_target"
                            class="input input-bordered w-full @error('daily_calorie_target') input-error @enderror"
                            value="{{ old('daily_calorie_target', session('onboarding.daily_calorie_target', 2000)) }}"
                            min="1000" max="5000" placeholder="2000">
                        @error('daily_calorie_target')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text">Daily Protein (g)</span>
                        </label>
                        <input type="number" name="daily_protein_target"
                            class="input input-bordered w-full @error('daily_protein_target') input-error @enderror"
                            value="{{ old('daily_protein_target', session('onboarding.daily_protein_target', 150)) }}"
                            min="50" max="300" placeholder="150">
                        @error('daily_protein_target')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text">Daily Carbs (g)</span>
                        </label>
                        <input type="number" name="daily_carbs_target"
                            class="input input-bordered w-full @error('daily_carbs_target') input-error @enderror"
                            value="{{ old('daily_carbs_target', session('onboarding.daily_carbs_target', 200)) }}"
                            min="50" max="500" placeholder="200">
                        @error('daily_carbs_target')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control mb-6">
                        <label class="label">
                            <span class="label-text">Daily Fat (g)</span>
                        </label>
                        <input type="number" name="daily_fat_target"
                            class="input input-bordered w-full @error('daily_fat_target') input-error @enderror"
                            value="{{ old('daily_fat_target', session('onboarding.daily_fat_target', 70)) }}"
                            min="20" max="200" placeholder="70">
                        @error('daily_fat_target')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control flex-row gap-3">
                        <a href="{{ route('onboarding.show', ['step' => 3]) }}" class="btn btn-outline flex-1">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Back
                        </a>
                        <button type="submit" class="btn btn-primary flex-1">
                            Next Step
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
