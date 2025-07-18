{{-- resources/views/components/meal-card.blade.php --}}
@props(['meal'])

<div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
    <div class="flex justify-between items-start mb-4">
        <div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $meal->description }}</h3>
            <span class="text-sm text-gray-500">{{ $meal->date->format('M d, Y') }}</span>
        </div>
        <div class="flex gap-2">
            {{-- Edit button --}}
            <a href="{{ route('meals.edit', $meal->id) }}" class="btn btn-primary">
                Edit
            </a>
            {{-- Delete button --}}
            <form action="{{ route('meals.destroy', $meal->id) }}" method="POST" class="inline"
                onsubmit="return confirm('Are you sure you want to delete this meal?');">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-secondary">
                    Delete
                </button>
            </form>
        </div>
    </div>

    {{-- Nutrition info grid --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-r from-orange-50 to-orange-100 p-3 rounded-lg">
            <div class="text-sm text-orange-600 font-medium">Calories</div>
            <div class="text-lg font-bold text-orange-800">{{ $meal->total_calories }}</div>
            <div class="text-xs text-orange-500">kcal</div>
        </div>
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-3 rounded-lg">
            <div class="text-sm text-blue-600 font-medium">Protein</div>
            <div class="text-lg font-bold text-blue-800">{{ $meal->protein }}</div>
            <div class="text-xs text-blue-500">g</div>
        </div>
        <div class="bg-gradient-to-r from-green-50 to-green-100 p-3 rounded-lg">
            <div class="text-sm text-green-600 font-medium">Carbs</div>
            <div class="text-lg font-bold text-green-800">{{ $meal->carbs }}</div>
            <div class="text-xs text-green-500">g</div>
        </div>
        <div class="bg-gradient-to-r from-purple-50 to-purple-100 p-3 rounded-lg">
            <div class="text-sm text-purple-600 font-medium">Fat</div>
            <div class="text-lg font-bold text-purple-800">{{ $meal->fat }}</div>
            <div class="text-xs text-purple-500">g</div>
        </div>
    </div>
</div>
