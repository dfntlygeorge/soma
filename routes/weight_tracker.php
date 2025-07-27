<?php

use App\Http\Controllers\WeightTrackerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get("/weight-tracker", [WeightTrackerController::class, "show"])->name("weight-tracker.show");
 
});