<?php

use App\Http\Controllers\MealController;
use Illuminate\Support\Facades\Route;

Route::prefix('meals')->name('meals.')->middleware('auth')->group(function () {
    Route::get('/history', [MealController::class, 'history'])->name('history'); // logged meals history page
    Route::post('/review', [MealController::class, 'analyze'])->name('review');
    Route::post('/confirm', [MealController::class, 'store'])->name('confirm');
    Route::get('/{meal}', [MealController::class, 'edit'])->name('edit'); // edit page
    Route::put('/{meal}', [MealController::class, 'update'])->name('update');
    Route::delete('/{meal}', [MealController::class, 'destroy'])->name('destroy');
});
