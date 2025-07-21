<x-app-layout>
    <x-slot name='title'>Meal Templates</x-slot>
    <div class="min-h-screen bg-gray-900 text-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-100 mb-2">Meal Templates</h1>
                        <p class="text-gray-400">Manage your saved meal templates</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        {{-- Add New Template Button --}}
                        <button x-data @click="$dispatch('open-modal', 'add-template-modal')"
                            class="inline-flex items-center px-4 py-2 bg-olive-600 hover:bg-olive-500 text-white font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Add New Template
                        </button>

                        {{-- Icon --}}
                        <div class="text-olive-400">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Templates Grid --}}
            @if ($saved_meals->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($saved_meals as $meal)
                        <x-meal-templates.meal-template-card :meal="$meal" />
                    @endforeach
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-12">
                    <div class="mx-auto w-24 h-24 bg-gray-800 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-400 mb-2">No meal templates yet</h3>
                    <p class="text-gray-500 mb-6">Create your first meal template to get started</p>
                    <button x-data @click="$dispatch('open-modal', 'add-template-modal')"
                        class="inline-flex items-center px-6 py-3 bg-olive-600 hover:bg-olive-500 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create First Template
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{-- Add Template Modal --}}
    <x-modal name="add-template-modal" :show="false" maxWidth="md">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Add New Template</h2>
                <button @click="$dispatch('close-modal', 'add-template-modal')"
                    class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Coming Soon Content --}}
            <div class="text-center py-8">
                <div class="mx-auto w-16 h-16 bg-olive-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-olive-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Feature Coming Soon</h3>
                <p class="text-gray-600 mb-6">We're working hard to bring you the ability to create custom meal
                    templates. Stay tuned!</p>

                {{-- Placeholder Form Preview --}}
                <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Template Name</label>
                            <div class="h-10 bg-gray-200 rounded-md"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Category</label>
                            <div class="h-10 bg-gray-200 rounded-md"></div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Calories</label>
                                <div class="h-10 bg-gray-200 rounded-md"></div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Protein (g)</label>
                                <div class="h-10 bg-gray-200 rounded-md"></div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Carbs (g)</label>
                                <div class="h-10 bg-gray-200 rounded-md"></div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Fat (g)</label>
                                <div class="h-10 bg-gray-200 rounded-md"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <button @click="$dispatch('close-modal', 'add-template-modal')"
                    class="px-6 py-2 bg-gray-300 text-gray-500 rounded-lg font-medium cursor-not-allowed">
                    Create Template (Coming Soon)
                </button>
            </div>
        </div>
    </x-modal>
</x-app-layout>
