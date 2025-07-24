<?php

use App\Http\Controllers\OnboardingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get("/onboarding", [OnboardingController::class, "show"])->name("onboarding.show");
    Route::post("/onboarding", [OnboardingController::class, "storeStep"])->name("onboarding.store");
    Route::get('/onboarding/get-recommendations', [OnboardingController::class, 'getRecommendations'])->name('onboarding.get-recommendations');
});