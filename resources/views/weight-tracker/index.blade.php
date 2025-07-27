<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cutting Progress Tracker</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-900 text-white p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-white">Cutting Progress</h1>
            <p class="text-gray-400 mt-1">Day {{ $currentDay }} of {{ $durationDays }} • {{ $startWeight }}kg →
                {{ $goalWeight }}kg
                Journey</p>
        </div>
        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center"
            onclick="openWeightModal()">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
            Log Weight
        </button>
    </div>

    <!-- Components -->
    @include('components.weight-tracker.progress-overview')
    @include('components.weight-tracker.milestones')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @include('components.weight-tracker.stats-cards')
        @include('components.weight-tracker.weight-chart')
    </div>

    @include('components.weight-tracker.weight-log-table')
    @include('components.weight-tracker.weight-modal')

    <script>
        // Modal functions
        function openWeightModal() {
            document.getElementById('weightModal').classList.remove('hidden');
        }

        function closeWeightModal() {
            document.getElementById('weightModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('weightModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeWeightModal();
            }
        });
    </script>
</body>

</html>
