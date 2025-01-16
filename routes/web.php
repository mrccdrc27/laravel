<?php

use App\Http\Controllers\RBAC;
use Illuminate\Support\Facades\Route;

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

Route::get('/home', [RBAC::class, 'index'])->name('home');
// Route::get('/core', function () {
//     return view('dashboard.student.submission');
// });
Route::get('/home', [RBAC::class, 'index'])->name('home');

// Route::middleware(middleware: ['auth:sanctum',config('jetstream.auth_session'),'verified'])->group(function () {
//     Route::get('/core', function () {return view('dashboard.student.submission');})->name('core');});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:faculty',
])->group(function () {
    Route::get('/core', function () {
        return view('dashboard.student.submission');
    })->name('core');
});
