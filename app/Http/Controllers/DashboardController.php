<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    // Show dashboard page

    public function show(): View {
        return view("dashboard");
    }
}