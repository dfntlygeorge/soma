<?php

use App\Http\Controllers\CharmyController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get("/charmy", [CharmyController::class, "index"])->name("charmy.index");
    Route::post('/charmy/suggest-from-history', [CharmyController::class, 'suggestFromHistory'])->name('charmy.history');
    Route::post('/charmy/suggest-ai', [CharmyController::class, 'suggestAI'])->name('charmy.ai');
});