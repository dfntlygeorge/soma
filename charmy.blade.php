   {{-- Step 3: Planned Meals Section --}}
   <div class="mb-8 hidden">
       <div class="flex items-center justify-between mb-6">
           <div class="flex items-center gap-3">
               <h2 class="text-2xl font-bold text-gray-100">Your Planned Meals</h2>
               {{-- <div class="badge badge-outline border-olive-500 text-olive-400">2 waiting</div> --}}
           </div>
           <button class="btn btn-sm btn-ghost text-olive-400 hover:bg-gray-800">
               Clear All
           </button>
       </div>

       <div class="space-y-4 hidden">
           {{-- Planned Meal 1 --}}
           <div class="card bg-gray-800 shadow-lg border border-gray-700 border-l-4 border-l-olive-500">
               <div class="card-body p-6">
                   <div class="flex justify-between items-start mb-4">
                       <div>
                           <div class="flex items-center gap-2 mb-2">
                               <h3 class="text-lg font-semibold text-gray-100">Heartbreak Fried Rice</h3>
                               <div class="badge badge-sm bg-olive-600 text-gray-900 border-none">Planned
                               </div>
                           </div>
                           <p class="text-sm text-gray-400 mb-2">Added 2 hours ago</p>
                           <p class="text-gray-400">Comfort food for when bae left you on read.</p>
                       </div>
                       <div class="text-right">
                           <div class="text-olive-400 font-semibold">420 cal</div>
                           <div class="text-xs text-gray-500">25P • 45C • 18F</div>
                       </div>
                   </div>

                   <div class="flex gap-3">
                       <button class="btn btn-sm bg-olive-600 hover:bg-olive-700 text-gray-900 border-none flex-1">
                           ✅ Log Instantly
                       </button>
                       <button
                           class="btn btn-sm btn-outline border-olive-500 text-olive-400 hover:bg-olive-500 hover:text-gray-900 flex-1">
                           ✏️ Edit & Log
                       </button>
                       <button class="btn btn-sm btn-ghost text-gray-400 hover:text-red-400">
                           🗑️
                       </button>
                   </div>
               </div>
           </div>

           {{-- Planned Meal 2 --}}
           <div class="card bg-gray-800 shadow-lg border border-gray-700 border-l-4 border-l-olive-500">
               <div class="card-body p-6">
                   <div class="flex justify-between items-start mb-4">
                       <div>
                           <div class="flex items-center gap-2 mb-2">
                               <h3 class="text-lg font-semibold text-gray-100">Love Potion Smoothie</h3>
                               <div class="badge badge-sm bg-olive-600 text-gray-900 border-none">Planned
                               </div>
                           </div>
                           <p class="text-sm text-gray-400 mb-2">Added 1 day ago</p>
                           <p class="text-gray-400">Berry smoothie that's sweeter than your crush's smile.</p>
                       </div>
                       <div class="text-right">
                           <div class="text-olive-400 font-semibold">285 cal</div>
                           <div class="text-xs text-gray-500">28P • 35C • 4F</div>
                       </div>
                   </div>

                   <div class="flex gap-3">
                       <button class="btn btn-sm bg-olive-600 hover:bg-olive-700 text-gray-900 border-none flex-1">
                           ✅ Log Instantly
                       </button>
                       <button
                           class="btn btn-sm btn-outline border-olive-500 text-olive-400 hover:bg-olive-500 hover:text-gray-900 flex-1">
                           ✏️ Edit & Log
                       </button>
                       <button class="btn btn-sm btn-ghost text-gray-400 hover:text-red-400">
                           🗑️
                       </button>
                   </div>
               </div>
           </div>
       </div>

       {{-- Empty State (when no planned meals) --}}
       <div class="text-center py-12">
           <div class="text-6xl mb-4">🍽️</div>
           <h3 class="text-lg font-semibold text-gray-300 mb-2">No planned meals yet</h3>
           <p class="text-gray-400 mb-6">Start by getting some meal suggestions above!</p>
       </div>
   </div>

   {{-- Quick Actions --}}
   <div class="card bg-gray-800 shadow-lg border border-gray-700 hidden">
       <div class="card-body p-6">
           <h3 class="text-lg font-semibold text-gray-100 mb-4">Quick Actions</h3>
           <div class="flex flex-wrap gap-3">
               <button
                   class="btn btn-sm btn-outline border-olive-500 text-olive-400 hover:bg-olive-500 hover:text-gray-900">
                   📝 Log Custom Meal
               </button>
               <button
                   class="btn btn-sm btn-outline border-olive-500 text-olive-400 hover:bg-olive-500 hover:text-gray-900">
                   🔄 Refresh Suggestions
               </button>
               <button
                   class="btn btn-sm btn-outline border-olive-500 text-olive-400 hover:bg-olive-500 hover:text-gray-900">
                   ⚙️ Preferences
               </button>
           </div>
       </div>
   </div>
