<?php

use App\Http\Controllers\OnboardingController;
use Illuminate\Support\Facades\Route;

Route::get("/onboarding", [OnboardingController::class, "show"])->name("onboarding.show");
Route::post("/onboarding", [OnboardingController::class, "storeStep"])->name("onboarding.store");
// New route for getting macro recommendations
Route::get('/onboarding/get-recommendations', [OnboardingController::class, 'getRecommendations'])->name('onboarding.get-recommendations');
