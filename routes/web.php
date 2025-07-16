<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MealController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard");
Route::post("/meals/confirm", [MealController::class, "store"])->name("meals.confirm");
Route::post("/meals/review", [MealController::class, "analyze"])->name("meals.review");
Route::delete('/meals/{meal}', [MealController::class, 'destroy'])->name('meals.destroy');
Route::get('/meals/{meal}', [MealController::class, 'edit'])->name('meals.edit');
Route::put('/meals/{meal}', [MealController::class, 'update'])->name('meals.update');
