<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="min-h-screen bg-gray-900 text-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-100 mb-2">Today's Macros</h1>
                    <p class="text-gray-400">Every kcal I track is a piece of me na hindi mo minahal.
                    </p>
                </div>
                <a href="{{ route('onboarding.show') }}"
                    class="flex items-center gap-2 text-olive-400 hover:text-olive-300 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                    </svg>
                    <span class="text-sm font-medium">Adjust Goals</span>
                </a>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div
                    class="bg-olive-900/50 border border-olive-600 text-olive-200 px-4 py-3 rounded-lg mb-6 backdrop-blur-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-olive-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- Two Column Layout for Large Screens --}}
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

                {{-- Left Column (60% - 3/5 of grid) - Overview Content --}}
                <div class="lg:col-span-3 space-y-8">

                    {{-- Macro target cards --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach ($daily_macros_target as $macro)
                            <x-dashboard.macro-card :macro="$macro" />
                        @endforeach
                    </div>

                    {{-- Streaks Section --}}
                    @include('components.dashboard.streaks')
                </div>

                {{-- Right Column (40% - 2/5 of grid) - Action Content --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Meal Logging Component --}}
                    <x-dashboard.meal-logger />

                    {{-- Meals section --}}
                    @include('components.meals-section')
                </div>
            </div>

            {{-- Review Modal --}}
            @include('components.dashboard.review-modal')
        </div>
    </div>
</x-app-layout>
