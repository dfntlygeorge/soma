<x-app-layout>
    <x-slot name="title">Start Cutting</x-slot>

    <div class="min-h-screen bg-gray-900 text-white p-6">
        <div class="max-w-md mx-auto">

            <h1 class="text-3xl font-bold text-center mb-8">Start Cutting</h1>

            @if ($errors->any())
                <div class="bg-red-900/50 border border-red-500 rounded-lg p-4 mb-6">
                    <ul class="text-red-300 text-sm space-y-1 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('weight-tracker.initialize') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Start Weight --}}
                <div>
                    <label for="start_weight" class="block text-sm text-gray-300 mb-2">
                        Current Weight (kg) *
                    </label>
                    <input type="number" id="start_weight" name="start_weight" step="0.1" min="0"
                        max="1000" value="{{ old('start_weight') }}"
                        class="w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 text-base"
                        placeholder="e.g., 80.5" required>
                    @error('start_weight')
                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Goal Weight --}}
                <div>
                    <label for="goal_weight" class="block text-sm text-gray-300 mb-2">
                        Goal Weight (kg) *
                    </label>
                    <input type="number" id="goal_weight" name="goal_weight" step="0.1" min="0"
                        max="1000" value="{{ old('goal_weight') }}"
                        class="w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 text-base"
                        placeholder="e.g., 75.0" required>
                    @error('goal_weight')
                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Info Note --}}
                <div class="text-sm text-gray-400 bg-blue-900/30 border border-blue-600/30 rounded-lg p-4">
                    Duration will be auto-calculated based on your deficit ({{ auth()->user()->calorie_deficit ?? 500 }}
                    kcal/day).
                </div>

                {{-- Submit Button --}}
                <div>
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg text-base transition duration-200">
                        Start Journey
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
