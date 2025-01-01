<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CertificationController;
use App\Http\Controllers\Api\V1\IssuerInformationController;

Route::get('/', function () {
    return view('welcome');
});

// Route to view specific certifaction with QR
Route::get('/certifications/{id}/qr-code', [CertificationController::class, 'showQR'])->name('certifications.qr-code');

// Route to view specific issuer details
Route::get('/issuers/{id}/details', [IssuerInformationController::class, 'showDetails'])
    ->name('issuers.details');

Route::fallback(function () {
    return view('errors.404');
});