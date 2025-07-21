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
        {{-- Suggest Meal Section --}}
        <div class="flex justify-center">
            <div class="relative">
                <button type="button" onclick="toggleSuggestDropdown()"
                    class="text-blue-400 hover:text-blue-300  decoration-1 hover:decoration-2 text-sm font-medium transition-all duration-200 flex items-center bg-transparent border-none p-0">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    Suggest Meal
                    {{-- <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg> --}}
                </button>

                {{-- Dropdown Menu --}}
                <div id="suggestDropdown"
                    class="absolute top-full right-0 mt-2 w-64 bg-gray-700 border border-gray-600 rounded-lg shadow-xl z-10 hidden">
                    <div class="py-2">
                        <button type="button"
                            class="w-full text-left px-4 py-3 text-gray-100 hover:bg-gray-600 transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-3 text-green-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <div class="font-medium">From Previous Meals</div>
                                <div class="text-sm text-gray-400">Based on pantry & macros</div>
                            </div>
                        </button>
                        <button type="button"
                            class="w-full text-left px-4 py-3 text-gray-100 hover:bg-gray-600 transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-3 text-purple-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <div>
                                <div class="font-medium">AI Suggestion</div>
                                <div class="text-sm text-gray-400">Generate new meal ideas</div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
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

<script>
    function toggleSuggestDropdown() {
        const dropdown = document.getElementById('suggestDropdown');
        dropdown.classList.toggle('hidden');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('suggestDropdown');
        const button = event.target.closest('button[onclick="toggleSuggestDropdown()"]');

        if (!button && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>
