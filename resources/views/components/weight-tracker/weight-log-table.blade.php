{{-- resources/views/components/weight-log-table.blade.php --}}

<!-- Weight Log History -->
<div class="mt-6">
    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-white">Recent Weight Logs</h3>
            <span class="text-sm text-gray-400">{{ $totalEntries }} entries total</span>
        </div>

        @if ($weightLogs && $weightLogs->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-gray-300 border-b border-gray-700">
                            <th class="text-left p-2">Date</th>
                            <th class="text-left p-2">Weight</th>
                            @if ($weightLogs->where('raw_change', '!=', null)->count() > 0)
                                <th class="text-left p-2">Change</th>
                            @endif
                            <th class="text-left p-2">Total Lost</th>
                            @if ($weightLogs->where('notes', '!=', null)->count() > 0)
                                <th class="text-left p-2">Notes</th>
                            @endif
                            <th class="text-left p-2"></th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-200">
                        @foreach ($weightLogs as $log)
                            <tr class="hover:bg-gray-700 border-b border-gray-800">
                                <td class="p-2">{{ $log['date'] }}</td>
                                <td class="p-2 font-semibold">{{ $log['weight'] }}</td>

                                @if ($weightLogs->where('raw_change', '!=', null)->count() > 0)
                                    <td class="p-2">
                                        @if ($log['change'])
                                            @php
                                                $changeValue = $log['change']['value'];
                                                $isPositive = str_starts_with($changeValue, '+');
                                                $changeColor = !$isPositive ? 'text-red-400' : 'text-green-400';
                                            @endphp
                                            <span class="{{ $changeColor }}">
                                                {{ $changeValue }}
                                            </span>
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </td>
                                @endif

                                <td class="p-2 text-green-400">{{ $log['total_lost'] }}</td>

                                @if ($weightLogs->where('notes', '!=', null)->count() > 0)
                                    <td class="p-2 text-sm text-gray-500">
                                        {{ $log['notes'] ?? '-' }}
                                    </td>
                                @endif


                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <div class="text-gray-400 mb-4">
                    <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                    <p class="text-lg">No weight logs yet</p>
                    <p class="text-sm">Start tracking your progress by adding your first weight entry.</p>
                </div>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    Add First Entry
                </button>
            </div>
        @endif
    </div>
</div>
