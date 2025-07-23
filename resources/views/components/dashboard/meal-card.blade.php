{{-- resources/views/components/meal-card.blade.php --}}
@props(['meal'])

<div
    class="bg-gray-800 border border-gray-700 rounded-lg p-3 shadow-lg hover:shadow-xl transition-all duration-200 hover:border-gray-600">
    {{-- Header row with category, time, and kebab menu --}}
    <div class="flex justify-between items-center mb-2">
        <div class="flex items-center space-x-2 flex-1 min-w-0">
            <div
                class="w-2 h-2 {{ match ($meal->category ?? 'snack') {
                    'breakfast' => 'bg-orange-400',
                    'lunch' => 'bg-green-400',
                    'dinner' => 'bg-purple-400',
                    'snack' => 'bg-pink-400',
                    default => 'bg-olive-400',
                } }} rounded-full flex-shrink-0">
            </div>
            <span class="text-xs font-medium text-gray-300 capitalize">{{ $meal->category ?? 'Meal' }}</span>
            <span class="text-xs text-gray-500">{{ $meal->created_at->format('g:i A') }}</span>
            <span class="text-xs text-gray-400">{{ $meal->date->format('M d') }}</span>
        </div>

        {{-- Compact Kebab Menu --}}
        <div class="relative ml-2 flex-shrink-0">
            <div class="kebab-menu">
                <button type="button"
                    class="kebab-trigger inline-flex items-center justify-center w-6 h-6 text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded-full transition-colors duration-200 focus:outline-none focus:ring-1 focus:ring-olive-500">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                    </svg>
                </button>

                <div
                    class="kebab-dropdown absolute right-0 mt-1 w-44 bg-gray-700 border border-gray-600 rounded-lg shadow-xl z-50 opacity-0 invisible transform scale-95 transition-all duration-200 origin-top-right">
                    <div class="py-1">
                        {{-- Edit Action --}}
                        <a href="{{ route('meals.edit', $meal->id) }}"
                            class="flex items-center px-3 py-1.5 text-xs text-gray-300 hover:bg-gray-600 hover:text-white transition-colors duration-150">
                            <svg class="w-3 h-3 mr-2 text-olive-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit meal
                        </a>

                        {{-- Create Template Action --}}
                        @if ($meal->saved_meal_id)
                            <button type="button" onclick="showTemplateModal('{{ $meal->id }}')"
                                class="w-full flex items-center px-3 py-1.5 text-xs text-gray-300 hover:bg-gray-600 hover:text-white transition-colors duration-150 text-left">
                                <svg class="w-3 h-3 mr-2 text-blue-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Create template
                            </button>
                        @else
                            <a href="{{ route('meals.templates.create', ['meal_id' => $meal->id]) }}"
                                class="w-full flex items-center px-3 py-1.5 text-xs text-gray-300 hover:bg-gray-600 hover:text-white transition-colors duration-150 text-left">
                                <svg class="w-3 h-3 mr-2 text-blue-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Create template
                            </a>
                        @endif

                        {{-- Separator --}}
                        <div class="border-t border-gray-600 my-1"></div>

                        {{-- Delete Action --}}
                        <form action="{{ route('meals.destroy', $meal->id) }}" method="POST" class="block"
                            onsubmit="return confirm('Are you sure you want to delete this meal?');">
                            @method('DELETE')
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center px-3 py-1.5 text-xs text-red-400 hover:bg-red-900/20 hover:text-red-300 transition-colors duration-150 text-left">
                                <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1v3M4 7h16" />
                                </svg>
                                Delete meal
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Meal description --}}
    <h3 class="text-sm font-medium text-gray-100 mb-2 leading-tight line-clamp-2">{{ $meal->description }}</h3>

    {{-- Horizontal layout for nutrition info --}}
    <div class="bg-gray-700/30 rounded-lg p-2">
        <div class="flex items-center justify-between">
            {{-- Calories prominently displayed --}}
            <div class="flex items-center space-x-2">
                <svg class="w-3 h-3 text-olive-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span class="text-sm font-bold text-olive-300">{{ $meal->total_calories }} kcal</span>
            </div>

            {{-- Compact macros in one line --}}
            <div class="flex items-center space-x-3 text-xs">
                <div class="text-blue-400">
                    <span class="font-medium">P:</span> {{ $meal->protein }}g
                </div>
                <div class="text-green-400">
                    <span class="font-medium">C:</span> {{ $meal->carbs }}g
                </div>
                <div class="text-purple-400">
                    <span class="font-medium">F:</span> {{ $meal->fat }}g
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Template Modal (unchanged but more compact) --}}
<div id="template-modal-{{ $meal->id }}"
    class="template-modal fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center opacity-0 invisible transition-all duration-300">
    <div
        class="bg-gray-800 border border-gray-700 rounded-xl p-5 max-w-sm w-full mx-4 transform scale-95 transition-transform duration-300">
        <div class="flex items-center mb-3">
            <div class="w-8 h-8 bg-blue-500/20 rounded-full flex items-center justify-center mr-3">
                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-gray-100">Template Already Exists</h3>
                <p class="text-xs text-gray-400">You already have a template for this meal.</p>
            </div>
        </div>

        <p class="text-sm text-gray-300 mb-4">Would you like to create a new template or update the existing one?</p>

        <div class="flex gap-2">
            <a href="{{ route('meals.templates.create', ['meal_id' => $meal->id]) }}"
                class="flex-1 text-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                Create New
            </a>
            <a href="{{ route('meals.templates.edit', ['meal_template_id' => $meal->saved_meal_id]) }}"
                class="flex-1 text-center px-3 py-2 bg-olive-600 hover:bg-olive-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                Update Existing
            </a>
        </div>

        <div class="mt-3 pt-3 border-t border-gray-700">
            <button type="button" onclick="hideTemplateModal('{{ $meal->id }}')"
                class="w-full px-3 py-2 text-gray-400 hover:text-gray-300 text-sm font-medium transition-colors duration-200">
                Cancel
            </button>
        </div>
    </div>
</div>

<style>
    .kebab-menu:focus-within .kebab-dropdown {
        opacity: 1;
        visibility: visible;
        transform: scale(1);
    }

    .kebab-trigger:focus+.kebab-dropdown,
    .kebab-dropdown:hover {
        opacity: 1;
        visibility: visible;
        transform: scale(1);
    }

    .template-modal.show {
        opacity: 1;
        visibility: visible;
    }

    .template-modal.show>div {
        transform: scale(1);
    }
</style>

<script>
    function showTemplateModal(mealId) {
        const modal = document.getElementById(`template-modal-${mealId}`);
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function hideTemplateModal(mealId) {
        const modal = document.getElementById(`template-modal-${mealId}`);
        modal.classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('template-modal')) {
            const mealId = e.target.id.replace('template-modal-', '');
            hideTemplateModal(mealId);
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const visibleModal = document.querySelector('.template-modal.show');
            if (visibleModal) {
                const mealId = visibleModal.id.replace('template-modal-', '');
                hideTemplateModal(mealId);
            }
        }
    });
</script>
