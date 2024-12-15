<?php

use App\Http\Controllers\QRController;
use App\Http\Controllers\ToyController;


Route::get('/', function () {
    return view('home'); // Default home page
})->name('home');

Route::get('/toys', [ToyController::class, 'index'])->name('toys'); // Toys page

Route::get('/qr', [QRController::class, 'index'])->name('qr-code'); // QR module home

Route::get('/qr/{id}', [QRController::class, 'create'])->name('qr-code.generate'); // Generated QR code 
