{{-- resources/views/components/weight-modal.blade.php --}}

<!-- Weight Logging Modal -->
<div id="weightModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 w-full max-w-md mx-4">
        <h3 class="font-bold text-lg text-white mb-4">Log Your Weight</h3>

        <form class="space-y-4">
            <div>
                <label class="block text-sm text-gray-300 mb-1">Weight (kg)</label>
                <input type="number" step="0.1" placeholder="68.5"
                    class="w-full px-3 py-2 bg-gray-700 border border-gray-600 text-white rounded-lg" />
            </div>

            <div>
                <label class="block text-sm text-gray-300 mb-1">Date</label>
                <input type="date" value="2025-07-27"
                    class="w-full px-3 py-2 bg-gray-700 border border-gray-600 text-white rounded-lg" />
            </div>

            <div>
                <label class="block text-sm text-gray-300 mb-1">Daily Deficit (kcal)</label>
                <input type="number" placeholder="500"
                    class="w-full px-3 py-2 bg-gray-700 border border-gray-600 text-white rounded-lg" />
            </div>

            <div>
                <label class="block text-sm text-gray-300 mb-1">Notes (optional)</label>
                <textarea class="w-full px-3 py-2 bg-gray-700 border border-gray-600 text-white rounded-lg"
                    placeholder="How are you feeling? Any observations?"></textarea>
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
