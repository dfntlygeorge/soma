{{-- resources/views/components/weight-log-table.blade.php --}}

<!-- Weight Log History -->
<div class="mt-6">
    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-white">Recent Weight Logs</h3>
            <span class="text-sm text-gray-400">9 entries total</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-gray-300 border-b border-gray-700">
                        <th class="text-left p-2">Date</th>
                        <th class="text-left p-2">Weight</th>
                        <th class="text-left p-2">Change</th>
                        <th class="text-left p-2">Total Lost</th>
                        <th class="text-left p-2">Deficit</th>
                        <th class="text-left p-2">Notes</th>
                        <th class="text-left p-2"></th>
                    </tr>
                </thead>
                <tbody class="text-gray-200">
                    <tr class="hover:bg-gray-700 border-b border-gray-800">
                        <td class="p-2">Jul 27, 2025</td>
                        <td class="p-2 font-semibold">68.5 kg</td>
                        <td class="p-2 text-red-400">-0.2 kg</td>
                        <td class="p-2 text-green-400">7.5 kg</td>
                        <td class="p-2 text-orange-400">-520 kcal</td>
                        <td class="p-2 text-sm text-gray-500">Feeling strong!</td>
                        <td class="p-2">
                            <button class="text-gray-400 hover:text-white text-xs">Edit</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-700 border-b border-gray-800">
                        <td class="p-2">Jul 20, 2025</td>
                        <td class="p-2 font-semibold">68.7 kg</td>
                        <td class="p-2 text-red-400">-0.3 kg</td>
                        <td class="p-2 text-green-400">7.3 kg</td>
                        <td class="p-2 text-orange-400">-480 kcal</td>
                        <td class="p-2 text-sm text-gray-500">Good week</td>
                        <td class="p-2">
                            <button class="text-gray-400 hover:text-white text-xs">Edit</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-700 border-b border-gray-800">
                        <td class="p-2">Jul 13, 2025</td>
                        <td class="p-2 font-semibold">69.0 kg</td>
                        <td class="p-2 text-red-400">-0.4 kg</td>
                        <td class="p-2 text-green-400">7.0 kg</td>
                        <td class="p-2 text-orange-400">-500 kcal</td>
                        <td class="p-2 text-sm text-gray-500">7kg milestone! 🎯</td>
                        <td class="p-2">
                            <button class="text-gray-400 hover:text-white text-xs">Edit</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
