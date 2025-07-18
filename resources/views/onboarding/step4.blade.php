<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-base-200 text-gray-200">
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

                <!-- Loading State -->
                <div id="loading-container" class="text-center py-12">
                    <div class="loading loading-spinner loading-lg text-primary mb-4"></div>
                    <h3 class="text-lg font-semibold mb-2">Calculating Your Personalized Nutrition Targets</h3>
                    <p class="text-base-content/60">We're analyzing your profile to create the perfect macro plan for
                        your goals...</p>
                </div>

                <!-- Error Message (hidden by default) -->
                <div id="error-message" class="alert alert-warning mb-4" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.98-.833-2.75 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    <span id="error-text"></span>
                </div>

                <!-- Content (hidden by default) -->
                <div id="content-container" style="display: none;">
                    <div class="alert alert-info mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="stroke-current shrink-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm">These are your personalized nutrition targets based on your profile. Ready
                            to continue?</span>
                    </div>

                    <form method="POST" action="{{ route('onboarding.store') }}">
                        @csrf
                        <input type="hidden" name="step" value="4">

                        <div class="form-control mb-4">
                            <label class="label">
                                <span class="label-text">Daily Calories</span>
                            </label>
                            <input type="text" id="calories-display" class="input input-bordered w-full bg-base-200"
                                readonly>
                        </div>

                        <div class="form-control mb-4">
                            <label class="label">
                                <span class="label-text">Daily Protein (g)</span>
                            </label>
                            <input type="text" id="protein-display" class="input input-bordered w-full bg-base-200"
                                readonly>
                        </div>

                        <div class="form-control mb-4">
                            <label class="label">
                                <span class="label-text">Daily Carbs (g)</span>
                            </label>
                            <input type="text" id="carbs-display" class="input input-bordered w-full bg-base-200"
                                readonly>
                        </div>

                        <div class="form-control mb-6">
                            <label class="label">
                                <span class="label-text">Daily Fat (g)</span>
                            </label>
                            <input type="text" id="fat-display" class="input input-bordered w-full bg-base-200"
                                readonly>
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
                                Continue
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loadingContainer = document.getElementById('loading-container');
            const contentContainer = document.getElementById('content-container');
            const errorMessage = document.getElementById('error-message');
            const errorText = document.getElementById('error-text');

            // Fetch recommendations
            fetch('{{ route('onboarding.get-recommendations') }}', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Hide loading
                    loadingContainer.style.display = 'none';

                    if (!data.success && data.message) {
                        // Show error message
                        errorText.textContent = data.message;
                        errorMessage.style.display = 'block';
                    }

                    // Populate the form with recommendations
                    document.getElementById('calories-display').value = data.data.calories + ' calories';
                    document.getElementById('protein-display').value = data.data.protein + 'g';
                    document.getElementById('carbs-display').value = data.data.carbs + 'g';
                    document.getElementById('fat-display').value = data.data.fat + 'g';

                    // Show content
                    contentContainer.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error fetching recommendations:', error);

                    // Hide loading
                    loadingContainer.style.display = 'none';

                    // Show error message
                    errorText.textContent =
                        'Unable to calculate personalized recommendations. Using default values.';
                    errorMessage.style.display = 'block';

                    // Show default values
                    document.getElementById('calories-display').value = '2000 calories';
                    document.getElementById('protein-display').value = '150g';
                    document.getElementById('carbs-display').value = '200g';
                    document.getElementById('fat-display').value = '70g';

                    // Show content
                    contentContainer.style.display = 'block';
                });
        });
    </script>
</x-app-layout>
