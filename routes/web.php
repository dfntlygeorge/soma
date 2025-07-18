<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\EnsureUserIsOnboarded;
use Illuminate\Support\Facades\Route;

// returns dashboard page with user, macros data.
Route::get("/dashboard", [DashboardController::class, "index"])->middleware(['auth', 'verified', EnsureUserIsOnboarded::class])->name("dashboard");

require __DIR__ . '/auth.php';
require __DIR__ . '/profile.php';
require __DIR__ . '/meals.php';
require __DIR__ . '/onboarding.php';
