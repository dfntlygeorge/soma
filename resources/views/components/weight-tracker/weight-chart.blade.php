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
            <canvas id="weightChart"></canvas>
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

<script>
    // Chart.js configuration
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('weightChart').getContext('2d');

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Apr 19', 'Apr 26', 'May 3', 'May 10', 'May 17', 'May 24', 'May 31', 'Jun 7',
                    'Jun 14', 'Jun 21', 'Jun 28', 'Jul 5', 'Jul 12', 'Jul 19', 'Jul 26', 'Aug 2',
                    'Aug 9'
                ],
                datasets: [{
                    label: 'Actual Weight',
                    data: [76.0, 75.2, 74.5, 73.8, 73.0, 72.1, 71.3, 70.5, 69.8, 69.2, 68.9,
                        68.7, 69.0, 68.7, 68.5, null, null
                    ],
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: false,
                    tension: 0.1,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }, {
                    label: 'Goal Weight',
                    data: Array(17).fill(65.0),
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    fill: false,
                    pointRadius: 0
                }, {
                    label: 'Prediction',
                    data: [null, null, null, null, null, null, null, null, null, null, null,
                        null, null, null, 68.5, 68.0, 67.5
                    ],
                    borderColor: '#8B5CF6',
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    borderWidth: 2,
                    borderDash: [3, 3],
                    fill: false,
                    tension: 0.1,
                    pointRadius: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(75, 85, 99, 0.3)'
                        },
                        ticks: {
                            color: '#9CA3AF'
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(75, 85, 99, 0.3)'
                        },
                        ticks: {
                            color: '#9CA3AF'
                        },
                        min: 64,
                        max: 77
                    }
                },
                elements: {
                    point: {
                        backgroundColor: '#1F2937'
                    }
                }
            }
        });
    });
</script>
