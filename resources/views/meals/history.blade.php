<x-app-layout>
    <x-slot name="title">Logged meals</x-slot>

    <div class="space-y-6">
        @forelse ($meals as $meal)
            <x-meal-card :meal="$meal" />
        @empty
            <div class="text-center py-12">
                <div class="text-gray-400 text-6xl mb-4">🍽️</div>
                <p class="text-gray-500 text-lg">No meals logged yet.</p>
                <p class="text-gray-400">Start tracking your nutrition by adding your first meal above!</p>
            </div>
        @endforelse
    </div>
</x-app-layout>
