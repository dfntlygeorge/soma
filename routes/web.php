<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\MacroController;
use App\Http\Middleware\EnsureUserIsOnboarded;
use Illuminate\Support\Facades\Route;

// returns dashboard page with user, macros data.
Route::get("/dashboard", [DashboardController::class, "index"])->middleware(['auth', EnsureUserIsOnboarded::class])->name("dashboard");
Route::redirect('/', '/dashboard');
Route::get("/macros/edit", [MacroController::class, 'show'])->middleware(['auth'])->name('macros.edit');
Route::put("/macros/edit", [MacroController::class, 'update'])->middleware(['auth'])->name('macros.update_macros');

Route::resource('ingredients', IngredientController::class)->middleware('auth');

require __DIR__ . '/auth.php';
require __DIR__ . '/profile.php';
require __DIR__ . '/meals_templates.php';
require __DIR__ . '/meals_history.php';
require __DIR__ . '/meals.php';
require __DIR__ . '/onboarding.php';
require __DIR__ . '/charmy.php';