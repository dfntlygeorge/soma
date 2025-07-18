<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-base-200 text-gray-200">
        <div class="card w-full max-w-md bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-center justify-center mb-6">Tell us about yourself</h2>

                <!-- Progress indicator -->
                <div class="mb-6">
                    <div class="flex justify-between text-sm text-base-content/60 mb-2">
                        <span>Step 1 of 5</span>
                        <span>Basic Info</span>
                    </div>
                    <progress class="progress progress-primary w-full" value="20" max="100"></progress>
                </div>

                <form method="POST" action="{{ route('onboarding.store') }}">
                    @csrf
                    <input type="hidden" name="step" value="1">

                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text">Age</span>
                        </label>
                        <input type="number" name="age"
                            class="input input-bordered w-full @error('age') input-error @enderror"
                            value="{{ old('age', session('onboarding.age')) }}" min="10" max="100"
                            placeholder="Enter your age">
                        @error('age')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text">Sex</span>
                        </label>
                        <select name="sex"
                            class="select select-bordered w-full @error('sex') select-error @enderror">
                            <option value="">Select your sex</option>
                            <option value="male"
                                {{ old('sex', session('onboarding.sex')) == 'male' ? 'selected' : '' }}>
                                Male</option>
                            <option value="female"
                                {{ old('sex', session('onboarding.sex')) == 'female' ? 'selected' : '' }}>Female
                            </option>
                        </select>
                        @error('sex')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text">Height (cm)</span>
                        </label>
                        <input type="number" name="height"
                            class="input input-bordered w-full @error('height') input-error @enderror"
                            value="{{ old('height', session('onboarding.height')) }}" min="50" max="300"
                            step="0.1" placeholder="Enter your height in cm">
                        @error('height')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control mb-6">
                        <label class="label">
                            <span class="label-text">Weight (kg)</span>
                        </label>
                        <input type="number" name="weight"
                            class="input input-bordered w-full @error('weight') input-error @enderror"
                            value="{{ old('weight', session('onboarding.weight')) }}" min="20" max="500"
                            step="0.1" placeholder="Enter your weight in kg">
                        @error('weight')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <button type="submit" class="btn btn-primary w-full">
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
