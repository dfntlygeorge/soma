<?php

use App\Http\Controllers\CreateTemplateController;
use App\Http\Controllers\EditTemplateController;
use App\Http\Controllers\MealTemplateController;
use Illuminate\Support\Facades\Route;

Route::prefix('meals/templates')->name('meals.templates.')->middleware('auth')->group(function () {

    // 📝 Show form to create a new template
    Route::get('/create', [CreateTemplateController::class, 'show'])->name('create');

    // 📥 Store a new template (form POST)
    Route::post('/create', [MealTemplateController::class, 'store'])->name('store');

    // 🛠 Show form to edit an existing template
    Route::get('/edit', [EditTemplateController::class, 'show'])->name('edit');

    // 💾 Update a specific template
    Route::put('/{meal_template}', [EditTemplateController::class, 'update'])->name('update');

    // 🗑 Delete a specific template
    Route::delete('/{meal_template}', [EditTemplateController::class, 'destroy'])->name('destroy');

    // 📋 List all templates (index page)
    Route::get('/', [EditTemplateController::class, 'index'])->name('index');
});
