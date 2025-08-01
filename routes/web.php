<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\MacroController;
use App\Http\Middleware\EnsureUserIsOnboarded;
use Illuminate\Support\Facades\Route;

Route::get('/weight-tracker', function () {
    return view('weight-tracker.index');
})->name('weight-tracker.index');

// returns dashboard page with user, macros data.
Route::get("/dashboard", [DashboardController::class, "index"])->middleware(['auth', EnsureUserIsOnboarded::class])->name("dashboard");
Route::redirect('/', '/dashboard');
Route::get("/macros/edit", [MacroController::class, 'show'])->middleware(['auth'])->name('macros.edit');
Route::put("/macros/edit", [MacroController::class, 'update'])->middleware(['auth'])->name('macros.update_macros');

Route::resource('ingredients', IngredientController::class)->middleware('auth');


Route::get('/rate-limit-exceeded', function () {
    $feature = session('feature', 'this feature');
    $limit = session('limit', 'the daily limit');

    return view('rate-limit.exceeded', compact('feature', 'limit'));
})->name('rate-limit-exceeded')->middleware('auth');

require __DIR__ . '/auth.php';
require __DIR__ . '/profile.php';
require __DIR__ . '/meals_templates.php';
require __DIR__ . '/meals_history.php';
require __DIR__ . '/meals.php';
require __DIR__ . '/onboarding.php';
require __DIR__ . '/charmy.php';
require __DIR__ . '/weight_tracker.php';
