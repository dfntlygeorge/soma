<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MealController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get("/dashboard", [DashboardController::class, "index"]);
Route::post("/meals", [MealController::class, "store"])->name("meals.store");
