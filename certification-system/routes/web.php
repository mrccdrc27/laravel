<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CertificationController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/certifications/{id}/qr-code', [CertificationController::class, 'showQR'])->name('certifications.qr-code');




