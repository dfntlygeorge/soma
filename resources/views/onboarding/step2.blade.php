<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-base-200">
        <div class="card w-full max-w-md bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-center justify-center mb-6">What's your goal?</h2>

                <!-- Progress indicator -->
                <div class="mb-6">
                    <div class="flex justify-between text-sm text-base-content/60 mb-2">
                        <span>Step 2 of 5</span>
                        <span>Your Goal</span>
                    </div>
                    <progress class="progress progress-primary w-full" value="40" max="100"></progress>
                </div>

                <form method="POST" action="{{ route('onboarding.store') }}">
                    @csrf
                    <input type="hidden" name="step" value="2">

                    <div class="form-control mb-6">
                        <label class="label">
                            <span class="label-text">Select your primary goal</span>
                        </label>

                        <div class="space-y-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="goal" value="lose" class="radio radio-primary"
                                    {{ old('goal', session('onboarding.goal')) == 'lose' ? 'checked' : '' }}>
                                <div class="card bg-base-200 ml-3 inline-block w-full">
                                    <div class="card-body py-4">
                                        <h3 class="font-semibold">Lose Weight</h3>
                                        <p class="text-sm text-base-content/70">Burn fat and achieve a leaner physique
                                        </p>
                                    </div>
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="goal" value="maintain" class="radio radio-primary"
                                    {{ old('goal', session('onboarding.goal')) == 'maintain' ? 'checked' : '' }}>
                                <div class="card bg-base-200 ml-3 inline-block w-full">
                                    <div class="card-body py-4">
                                        <h3 class="font-semibold">Maintain Weight</h3>
                                        <p class="text-sm text-base-content/70">Stay at your current weight and improve
                                            fitness</p>
                                    </div>
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="goal" value="gain" class="radio radio-primary"
                                    {{ old('goal', session('onboarding.goal')) == 'gain' ? 'checked' : '' }}>
                                <div class="card bg-base-200 ml-3 inline-block w-full">
                                    <div class="card-body py-4">
                                        <h3 class="font-semibold">Gain Weight</h3>
                                        <p class="text-sm text-base-content/70">Build muscle and increase overall mass
                                        </p>
                                    </div>
                                </div>
                            </label>
                        </div>

                        @error('goal')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control flex-row gap-3">
                        <a href="{{ route('onboarding.show', ['step' => 1]) }}" class="btn btn-outline flex-1">
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
