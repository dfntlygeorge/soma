<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-base-200">
        <div class="card w-full max-w-md bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-center justify-center mb-6">Activity Level</h2>

                <!-- Progress indicator -->
                <div class="mb-6">
                    <div class="flex justify-between text-sm text-base-content/60 mb-2">
                        <span>Step 3 of 5</span>
                        <span>Activity Level</span>
                    </div>
                    <progress class="progress progress-primary w-full" value="60" max="100"></progress>
                </div>

                <form method="POST" action="{{ route('onboarding.store') }}">
                    @csrf
                    <input type="hidden" name="step" value="3">

                    <div class="form-control mb-6">
                        <label class="label">
                            <span class="label-text">How active are you?</span>
                        </label>

                        <div class="space-y-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="activity_level" value="sedentary"
                                    class="radio radio-primary"
                                    {{ old('activity_level', session('onboarding.activity_level')) == 'sedentary' ? 'checked' : '' }}>
                                <div class="card bg-base-200 ml-3 inline-block w-full">
                                    <div class="card-body py-4">
                                        <h3 class="font-semibold">Sedentary</h3>
                                        <p class="text-sm text-base-content/70">Little or no exercise, desk job</p>
                                    </div>
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="activity_level" value="light" class="radio radio-primary"
                                    {{ old('activity_level', session('onboarding.activity_level')) == 'light' ? 'checked' : '' }}>
                                <div class="card bg-base-200 ml-3 inline-block w-full">
                                    <div class="card-body py-4">
                                        <h3 class="font-semibold">Light Activity</h3>
                                        <p class="text-sm text-base-content/70">Light exercise 1-3 days per week</p>
                                    </div>
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="activity_level" value="moderate" class="radio radio-primary"
                                    {{ old('activity_level', session('onboarding.activity_level')) == 'moderate' ? 'checked' : '' }}>
                                <div class="card bg-base-200 ml-3 inline-block w-full">
                                    <div class="card-body py-4">
                                        <h3 class="font-semibold">Moderate Activity</h3>
                                        <p class="text-sm text-base-content/70">Moderate exercise 3-5 days per week</p>
                                    </div>
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="activity_level" value="active" class="radio radio-primary"
                                    {{ old('activity_level', session('onboarding.activity_level')) == 'active' ? 'checked' : '' }}>
                                <div class="card bg-base-200 ml-3 inline-block w-full">
                                    <div class="card-body py-4">
                                        <h3 class="font-semibold">Very Active</h3>
                                        <p class="text-sm text-base-content/70">Hard exercise 6-7 days per week</p>
                                    </div>
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="activity_level" value="extra" class="radio radio-primary"
                                    {{ old('activity_level', session('onboarding.activity_level')) == 'extra' ? 'checked' : '' }}>
                                <div class="card bg-base-200 ml-3 inline-block w-full">
                                    <div class="card-body py-4">
                                        <h3 class="font-semibold">Extra Active</h3>
                                        <p class="text-sm text-base-content/70">Very hard exercise, physical job or
                                            training
                                        </p>
                                    </div>
                                </div>
                            </label>
                        </div>

                        @error('activity_level')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control flex-row gap-3">
                        <a href="{{ route('onboarding.show', ['step' => 2]) }}" class="btn btn-outline flex-1">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7">
                                </path>
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
