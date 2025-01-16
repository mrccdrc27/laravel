<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\createCoursecontroller;
Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Route to show the course creation form
    Route::get('/faculty/createCourse', [createCoursecontroller::class, 'showCreateCourseForm'])->name('faculty.CreateCourseForm');

    // Route to handle form submission (POST)
    Route::post('/faculty/createCourse', [createCoursecontroller::class, 'createCourse'])->name('faculty.createCourse');
});