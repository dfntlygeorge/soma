<x-app-layout>
    <x-slot name="title">Edit Macros</x-slot>

    <div class="min-h-screen bg-gray-900 text-gray-100 py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->

            <div class="mb-8">
                <div class="flex items-center gap-4 mb-4">
                    <a href="{{ route('dashboard') }}" class="text-olive-400 hover:text-olive-300 font-medium">
                        ← Back to Dashboard
                    </a>
                </div>
                <h1 class="text-3xl font-bold text-gray-100">Update Your Macros</h1>
                <p class="text-gray-400">Set your goals. Be consistent. Jowa will follow (maybe).</p>
            </div>



            <!-- Success & Error Messages -->
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <strong class="font-bold">Fix these:</strong>
                    <ul class="text-sm mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-6">
                <form action="{{ route('macros.update_macros') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="form-control">
                        <label for="daily_calorie_target" class="label">Calories (kcal)</label>
                        <input type="number" name="daily_calorie_target" id="daily_calorie_target"
                            value="{{ old('daily_calorie_target', $daily_calorie_target) }}"
                            class="input input-bordered w-full" required>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="form-control">
                            <label for="daily_protein_target" class="label">Protein (g)</label>
                            <input type="number" name="daily_protein_target" id="daily_protein_target"
                                value="{{ old('daily_protein_target', $daily_protein_target) }}"
                                class="input input-bordered w-full" required>
                        </div>

                        <div class="form-control">
                            <label for="daily_carbs_target" class="label">Carbs (g)</label>
                            <input type="number" name="daily_carbs_target" id="daily_carbs_target"
                                value="{{ old('daily_carbs_target', $daily_carbs_target) }}"
                                class="input input-bordered w-full" required>
                        </div>

                        <div class="form-control">
                            <label for="daily_fat_target" class="label">Fat (g)</label>
                            <input type="number" name="daily_fat_target" id="daily_fat_target"
                                value="{{ old('daily_fat_target', $daily_fat_target) }}"
                                class="input input-bordered w-full" required>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 pt-4">
                        <button type="reset" class="btn btn-outline">Reset</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
            <!-- Macro Form -->

            <!-- Hugot Tips -->
            <div class="mt-8 space-y-2">
                <div class="alert bg-gray-700 text-sm text-gray-100">
                    💪 <span class="font-medium">Tip:</span> Protein helps you build muscle... and maybe confidence to
                    DM her.
                </div>
                <div class="alert bg-gray-800 text-sm text-gray-100">
                    🥲 Kaya ka walang jowa, kasi carbs lang ang minamahal mo.
                </div>
                <div class="alert bg-olive-800 text-sm text-gray-100">
                    🥑 Don't skip fats — hindi porket may “fat” eh toxic agad, minsan healthy yan.
                </div>
            </div>

        </div>
    </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-100">
            {{ __('Edit Daily Macros') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 shadow sm:rounded-lg p-6 space-y-6">
                {{-- Paste your entire custom UI here --}}
                {{-- Header, Form, Tips, Everything — already styled the way you like it --}}
            </div>
        </div>
    </div>
</x-app-layout>
