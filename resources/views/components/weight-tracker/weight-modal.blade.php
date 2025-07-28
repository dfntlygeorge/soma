{{-- resources/views/components/weight-modal.blade.php --}}

<!-- Weight Logging Modal -->
<div id="weightModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 w-full max-w-md mx-4">
        <h3 class="font-bold text-lg text-white mb-4">Log Your Weight</h3>

        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-600 text-white rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Display success message -->
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-600 text-white rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('weight-tracker.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm text-gray-300 mb-1">Weight (kg)</label>
                <input type="number" name="weight" step="0.1" placeholder="68.5" value="{{ old('weight') }}"
                    required class="w-full px-3 py-2 bg-gray-700 border border-gray-600 text-white rounded-lg" />
            </div>

            <div>
                <label class="block text-sm text-gray-300 mb-1">Date</label>
                <input type="date" name="date" value="{{ old('date', now()->toDateString()) }}" required
                    class="w-full px-3 py-2 bg-gray-700 border border-gray-600 text-white rounded-lg" />
            </div>

            <div>
                <label class="block text-sm text-gray-300 mb-1">Notes (optional)</label>
                <textarea name="notes" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 text-white rounded-lg"
                    placeholder="How are you feeling? Any observations?" rows="3">{{ old('notes') }}</textarea>
            </div>

            <div class="flex space-x-3 mt-6">
                <button type="button" class="flex-1 px-4 py-2 bg-gray-700 text-gray-400 rounded-lg hover:bg-gray-600"
                    onclick="closeWeightModal()">Cancel</button>
                <button type="submit"
                    class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Save Weight</button>
            </div>
        </form>
    </div>
</div>

<script>
    function closeWeightModal() {
        document.getElementById('weightModal').classList.add('hidden');
    }

    function openWeightModal() {
        document.getElementById('weightModal').classList.remove('hidden');
    }

    // Auto-open modal if there are validation errors or success message
    @if ($errors->any() || session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            openWeightModal();
        });
    @endif
</script>
