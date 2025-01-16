<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function dashboard()
    {
        return view('/student/dashboard'); // Ensure this view exists
    }
}
