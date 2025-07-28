<?php

use App\Http\Controllers\WeightTrackerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get("/weight-tracker", [WeightTrackerController::class, "show"])->name("weight-tracker.show");
    Route::post("/weight-tracker", [WeightTrackerController::class, "store"])->name("weight-tracker.store");
    Route::post('/weight-tracker/initialize', [WeightTrackerController::class, 'initializeCutting'])
        ->name('weight-tracker.initialize');
});
