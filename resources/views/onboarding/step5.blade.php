<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-base-200 text-gray-200">
        <div class="card w-full max-w-md bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-center justify-center mb-6">Confirm Your Profile</h2>

                <!-- Progress indicator -->
                <div class="mb-6">
                    <div class="flex justify-between text-sm text-base-content/60 mb-2">
                        <span>Step 5 of 5</span>
                        <span>Review & Confirm</span>
                    </div>
                    <progress class="progress progress-primary w-full" value="100" max="100"></progress>
                </div>

                <div class="space-y-4 mb-6">
                    <!-- Basic Info -->
                    <div class="card bg-base-200">
                        <div class="card-body py-4">
                            <h3 class="font-semibold text-sm">Basic Information</h3>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div>
                                    <span class="text-base-content/70">Age:</span>
                                    <span class="font-medium">{{ session('onboarding.age') }} years</span>
                                </div>
                                <div>
                                    <span class="text-base-content/70">Sex:</span>
                                    <span class="font-medium capitalize">{{ session('onboarding.sex') }}</span>
                                </div>
                                <div>
                                    <span class="text-base-content/70">Height:</span>
                                    <span class="font-medium">{{ session('onboarding.height') }} cm</span>
                                </div>
                                <div>
                                    <span class="text-base-content/70">Weight:</span>
                                    <span class="font-medium">{{ session('onboarding.weight') }} kg</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Goal & Activity -->
                    <div class="card bg-base-200">
                        <div class="card-body py-4">
                            <h3 class="font-semibold text-sm">Goal & Activity</h3>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div>
                                    <span class="text-base-content/70">Goal:</span>
                                    <span class="font-medium capitalize">{{ session('onboarding.goal') }} weight</span>
                                </div>
                                <div>
                                    <span class="text-base-content/70">Activity:</span>
                                    <span
                                        class="font-medium capitalize">{{ str_replace('_', ' ', session('onboarding.activity_level')) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nutrition Targets -->
                    <div class="card bg-base-200">
                        <div class="card-body py-4">
                            <h3 class="font-semibold text-sm">Daily Nutrition Targets</h3>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div>
                                    <span class="text-base-content/70">Calories:</span>
                                    <span class="font-medium">{{ session('onboarding.daily_calorie_target') }}
                                        kcal</span>
                                </div>
                                <div>
                                    <span class="text-base-content/70">Protein:</span>
                                    <span class="font-medium">{{ session('onboarding.daily_protein_target') }}g</span>
                                </div>
                                <div>
                                    <span class="text-base-content/70">Carbs:</span>
                                    <span class="font-medium">{{ session('onboarding.daily_carbs_target') }}g</span>
                                </div>
                                <div>
                                    <span class="text-base-content/70">Fat:</span>
                                    <span class="font-medium">{{ session('onboarding.daily_fat_target') }}g</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-success mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span
                        class="text-sm">{{ $onboarded ? 'Ready to update your targets' : 'Ready to complete your profile setup' }}</span>
                </div>

                <form method="POST" action="{{ route('onboarding.store') }}">
                    @csrf
                    <input type="hidden" name="step" value="5">

                    <div class="flex gap-3 justify-between">
                        <a href="{{ route('onboarding.show', ['step' => 4]) }}" class="btn btn-outline flex-1">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7">
                                </path>
                            </svg>
                            Back
                        </a>
                        <button type="submit" class="btn btn-primary flex-1">
                            Complete Setup
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
