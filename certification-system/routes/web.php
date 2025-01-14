<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CertificationController;
use App\Http\Controllers\display;


Route::get('certificate', function () {
    return view('dashboard.certificate');
})->name('certificate');

// Route::get('home', function () {
//     return view('dashboard.home');
// })->name('home');
// Route::get('home', function () {
//     return view('dashboard.home');
// });
Route::get('home', [display::class, 'index'])->name('home');
Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('about', function () {
    return view('dashboard.about');
})->name('about');

Route::get('search', function () {
    return view('dashboard.search');
})->name('search');

Route::get('certificate/user', function () {
    return view('dashboard.cert.user');
})->name('certificate/user');

Route::get('certificate/issuer', function () {
    return view('dashboard.cert.issuer');
})->name('certificate/issuer');

Route::get('certificate/org', function () {
    return view('dashboard.cert.org');
})->name('certificate/org');

Route::get('certificate/create', function () {
    return view('dashboard.cert.create');
})->name('certificate/create');


