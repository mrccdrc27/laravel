<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CertificationController;


Route::get('certificate', function () {
    return view('dashboard.certificate');
})->name('certificate');

Route::get('home', function () {
    return view('dashboard.home');
})->name('home');

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('about', function () {
    return view('dashboard.about');
})->name('about');

Route::get('search', function () {
    return view('dashboard.search');
})->name('search');