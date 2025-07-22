<div class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-6 mb-8">
    <div class="flex items-center mb-4 justify-between">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-olive-600 rounded-lg flex items-center justify-center mr-3">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-100">Log New Meal</h2>
        </div>
        <div class="flex justify-center mt-6">
            <a href="{{ route('charmy.index') }}"
                class="text-blue-400 hover:text-blue-300 text-sm font-medium flex items-center gap-2 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Need Charmy?
            </a>
        </div>

    </div>


    <form action="{{ route('meals.review') }}" method="POST" class="flex flex-col gap-3 lg:flex-row lg:items-center">
        @csrf

        {{-- Input field --}}
        <input type="text" name="description" placeholder="Example: 100g chicken, 1 cup rice"
            class="flex-1 px-4 py-3 bg-gray-700 border border-gray-600 text-gray-100 rounded-lg focus:ring-2 focus:ring-olive-500 focus:border-olive-500 placeholder-gray-400 transition-colors"
            required>

        {{-- Action buttons --}}
        <div class="flex gap-2">
            {{-- Log Meal Button --}}
            <button type="submit"
                class="bg-olive-600 hover:bg-olive-700 text-white px-5 py-3 rounded-lg font-medium transition-all duration-200 transform hover:scale-105 focus:ring-2 focus:ring-olive-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                <span class="flex items-center justify-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    Log Meal
                </span>
            </button>

            {{-- Use Template Button --}}
            <a href="{{ route('meal-templates.index') }}"
                class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-3 rounded-lg font-medium transition-all duration-200 transform hover:scale-105 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-800 whitespace-nowrap flex items-center justify-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                Use Template
            </a>
        </div>
    </form>
</div>
