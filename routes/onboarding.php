<?php

use Illuminate\Support\Facades\Route;

Route::get("/onboarding", function () {
    return view("onboarding.index");
});
