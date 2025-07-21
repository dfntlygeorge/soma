<?php

use App\Http\Controllers\CreateTemplateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EditTemplateController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\MacroController;
use App\Http\Controllers\MealTemplateController;
use App\Http\Middleware\EnsureUserIsOnboarded;
use Illuminate\Support\Facades\Route;

// returns dashboard page with user, macros data.
Route::get("/dashboard", [DashboardController::class, "index"])->middleware(['auth', 'verified', EnsureUserIsOnboarded::class])->name("dashboard");
Route::get("/macros/edit", [MacroController::class, 'show'])->name('macros.edit');
Route::put("/macros/edit", [MacroController::class, 'update'])->name('macros.update_macros');
Route::get('/meals/templates/create', [CreateTemplateController::class, 'show'])->name('meal-templates.create');
Route::get('/meals/templates/edit', [EditTemplateController::class, 'show'])->name('meal-templates.edit');
Route::put('/meals/templates/{meal_template}', [EditTemplateController::class, 'update'])->name('meal-templates.update');
Route::delete('/meals/templates/{meal_template}/', [EditTemplateController::class, 'destroy'])->name('meal-templates.destroy');
Route::post('/meals/templates/create', [MealTemplateController::class, 'store'])->name('meal-templates.store');
// Route::put('/meals/templates/{meal}', [MealTemplateController::class, 'store'])->name('meal-templates.update');

// // temp
// Route::get('/meals/templates/{meal_template}/edit', [EditTemplateController::class, 'edit'])->name('meal-templates.edit'); // edit form
// Route::put('/meals/templates/{meal_template}', [EditTemplateController::class, 'update'])->name('meal-templates.update'); // form submit
// Route::delete('/meals/templates/{meal_template}', [EditTemplateController::class, 'destroy'])->name('meal-templates.destroy'); // delete
Route::get('/meals/templates', [EditTemplateController::class, 'index'])->name('meal-templates.index'); // back to list

Route::resource('ingredients', IngredientController::class)->middleware('auth');

require __DIR__ . '/auth.php';
require __DIR__ . '/profile.php';
require __DIR__ . '/meals.php';
require __DIR__ . '/onboarding.php';
