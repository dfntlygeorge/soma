<x-app-layout>
    <x-slot name="title">My Pantry</x-slot>

    <div class="min-h-screen bg-gray-900 text-gray-100 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center gap-4 mb-4">
                    <a href="{{ route('dashboard') }}"
                        class="text-olive-400 hover:text-olive-300 font-medium transition-colors">
                        ← Back to Dashboard
                    </a>
                </div>
                <h1 class="text-3xl font-bold text-gray-100 mb-2">My Pantry</h1>
                <p class="text-gray-400">Keep it updated, always. Parang ikaw sa ka-situationship mo 😔</p>
            </div>

            {{-- Add Item Section --}}
            <div class="bg-gray-800 rounded-lg p-6 mb-6">
                <form action="{{ route('ingredients.store') }}" method="POST" class="flex gap-3">
                    @csrf
                    <input type="text" name="name" placeholder="e.g. Chicken Breast, Soy Sauce, Eggs..."
                        class="input input-bordered bg-gray-700 border-gray-600 text-gray-100 placeholder-gray-400 flex-1 focus:border-olive-400 focus:ring-olive-400"
                        required>
                    <button type="submit"
                        class="btn bg-olive-600 hover:bg-olive-500 text-white border-olive-600 hover:border-olive-500">
                        Add
                    </button>
                </form>
            </div>

            {{-- Pantry Items List --}}
            <div class="bg-gray-800 rounded-lg">
                @if ($ingredients->count() > 0)
                    <div class="divide-y divide-gray-700">
                        @foreach ($ingredients as $ingredient)
                            <div class="flex items-center justify-between p-4 hover:bg-gray-750 transition-colors">
                                <span class="text-gray-100">{{ $ingredient->name }}</span>
                                <form action="{{ route('ingredients.destroy', $ingredient) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-400 hover:text-red-300 text-sm transition-colors">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="text-center py-12">
                        <div class="text-gray-400 text-lg mb-2">You haven't added any ingredients yet</div>
                        <p class="text-gray-500 text-sm">Start by adding items you currently have in your kitchen</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
