<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MealController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get("/dashboard", [DashboardController::class, "index"])->middleware(['auth', 'verified'])->name("dashboard");
Route::post("/meals/review", [MealController::class, "analyze"])->name("meals.review");
Route::delete('/meals/{meal}', [MealController::class, 'destroy'])->name('meals.destroy');
Route::get('/meals/{meal}', [MealController::class, 'edit'])->name('meals.edit');
Route::put('/meals/{meal}', [MealController::class, 'update'])->name('meals.update');



Route::post("/meals/confirm", [MealController::class, "store"])->name("meals.confirm");

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
