<div class="bg-gray-800 border border-gray-700 rounded-lg shadow-lg p-4 h-fit">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-3">
        <div class="flex items-center">
            <div class="w-6 h-6 bg-olive-600 rounded-md flex items-center justify-center mr-2">
                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </div>
            <h2 class="text-base font-semibold text-gray-100">Log New Meal</h2>
        </div>
        <a href="{{ route('charmy.index') }}"
            class="text-blue-400 hover:text-blue-300 text-xs font-medium flex items-center gap-1 transition-colors duration-200">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Charmy
        </a>
    </div>

    {{-- Form --}}
    <form action="{{ route('meals.review') }}" method="POST" class="space-y-3">
        @csrf

        {{-- Input field --}}
        <textarea name="description" placeholder="100g chicken, 1 cup rice..." rows="3"
            class="w-full px-3 py-2 bg-gray-700 border border-gray-600 text-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-olive-500 focus:border-olive-500 placeholder-gray-400 transition-colors resize-y"
            required></textarea>

        {{-- Action buttons --}}
        <div class="flex gap-2">
            {{-- Log Meal Button --}}
            <button type="submit"
                class="flex-1 bg-olive-600 hover:bg-olive-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 focus:ring-2 focus:ring-olive-500">
                <span class="flex items-center justify-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    Log Meal
                </span>
            </button>

            {{-- Use Template Button --}}
            <a href="{{ route('meals.templates.index') }}"
                class="flex-1 bg-gray-700 hover:bg-gray-600 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 focus:ring-2 focus:ring-gray-500 flex items-center justify-center">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                Templates
            </a>
        </div>
    </form>
</div>
