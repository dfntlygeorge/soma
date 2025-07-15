<x-layout>
    <x-slot name="title">Dashboard</x-slot>

    <h1 class="text-3xl text-gray-800 font-bold mb-6">Today's Macros</h1>

    {{-- Macro target cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        @foreach ($daily_macros_target as $macro)
            <div class="border rounded-lg p-4 text-center shadow bg-white">
                <div class="text-2xl font-bold">
                    {{ $macro['daily_target'] }} {{ $macro['unit'] }}
                </div>
                <div class="text-gray-600">
                    {{ $macro['label'] }}
                </div>
                <div class="text-gray-400 text-sm">
                    {{ $macro['left'] }} left
                </div>
            </div>
        @endforeach
    </div>

    {{-- Meals section --}}
    <h2 class="text-2xl text-gray-700 font-semibold mb-4">Logged Meals</h2>

    <div class="space-y-4 mb-8">
        @forelse ($meals as $meal)
            <div class="border rounded-lg p-4 shadow bg-white">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-bold text-gray-800">{{ $meal->description }}</h3>
                    <span class="text-sm text-gray-500">{{ $meal->date->format('M d, Y') }}</span>
                </div>
                <div class="flex flex-wrap gap-4 text-sm text-gray-700">
                    <span><strong>Calories:</strong> {{ $meal->total_calories }}</span>
                    <span><strong>Protein:</strong> {{ $meal->protein }}g</span>
                    <span><strong>Carbs:</strong> {{ $meal->carbs }}g</span>
                    <span><strong>Fat:</strong> {{ $meal->fat }}g</span>
                </div>
            </div>
        @empty
            <p class="text-gray-500">No meals logged yet.</p>
        @endforelse
    </div>

    {{-- Show Gemini response for testing --}}
    @if (!empty($macros))
        <h2 class="text-xl text-gray-700 font-semibold mb-2">New Meal (Gemini Response)</h2>
        <div class="border rounded-lg p-4 shadow bg-green-50">
            <p><strong>Description:</strong> {{ $macros['description'] ?? 'N/A' }}</p>
            <p><strong>Calories:</strong> {{ $macros['total_calories'] ?? 'N/A' }}</p>
            <p><strong>Protein:</strong> {{ $macros['protein'] ?? 'N/A' }}g</p>
            <p><strong>Carbs:</strong> {{ $macros['carbs'] ?? 'N/A' }}g</p>
            <p><strong>Fat:</strong> {{ $macros['fat'] ?? 'N/A' }}g</p>
        </div>
    @endif

    <form action="{{ route(name: 'meals.store') }}" method="POST">
        @csrf
        <input type="text" name="description" placeholder="Example: 100g chicken, 1 cup rice">
        <button type="submit">Log Meal</button>
    </form>


</x-layout>
