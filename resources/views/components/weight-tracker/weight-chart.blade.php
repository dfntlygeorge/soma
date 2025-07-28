{{-- resources/views/components/weight-chart.blade.php --}}

<!-- Chart Section -->
<div class="lg:col-span-2">
    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 h-full">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-white">Weight Progress Chart</h3>
            <div class="flex space-x-2">
                <button
                    class="px-3 py-1 bg-gray-700 border border-gray-600 text-white text-sm rounded hover:bg-gray-600">1M</button>
                <button class="px-3 py-1 bg-green-600 border border-green-600 text-white text-sm rounded">3M</button>
                <button
                    class="px-3 py-1 bg-gray-700 border border-gray-600 text-white text-sm rounded hover:bg-gray-600">6M</button>
                <button
                    class="px-3 py-1 bg-gray-700 border border-gray-600 text-white text-sm rounded hover:bg-gray-600">All</button>
            </div>
        </div>
        <div class="relative" style="height: 400px;">
            <x-chartjs-component :chart="$chart" />
        </div>

        <!-- Chart Legend -->
        <div class="flex justify-center mt-4 space-x-6 text-sm">
            <div class="flex items-center">
                <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                <span class="text-gray-300">Actual Weight</span>
            </div>
            <div class="flex items-center">
                <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                <span class="text-gray-300">Goal Weight</span>
            </div>
            <div class="flex items-center">
                <div class="w-3 h-3 bg-purple-500 rounded-full mr-2"></div>
                <span class="text-gray-300">Prediction</span>
            </div>
        </div>
    </div>
</div>
