<?php

use App\Http\Controllers\MealHistoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('meals/history')->name('meals.history.')->middleware('auth')->group(function () {
    Route::get('/', [MealHistoryController::class, 'index'])->name('index'); // logged meals history page
});
