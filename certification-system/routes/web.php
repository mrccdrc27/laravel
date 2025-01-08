<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CertificationController;
use App\Http\Controllers\Api\V1\IssuerInformationController;

Route::get('/', function () {
    return view('welcome');
});


// Certification Routes
Route::prefix('certifications')->name('certifications.')->group(function () {
    Route::get('/{id}/qr-code', [CertificationController::class, 'showQR'])->name('qr-code');
});

// Issuer Information Routes
Route::prefix('issuers')->name('issuers.')->group(function () {
    Route::get('/{id}/details', [IssuerInformationController::class, 'showDetails'])->name('details');
    // Asset routes
    Route::get('/{id}/logo', [IssuerInformationController::class, 'getLogo'])->name('logo');
    Route::get('/{id}/signature', [IssuerInformationController::class, 'getSignature'])->name('signature');
    
    /* Example in a view:
    <img src="{{ route('issuers.signature', $issuer->IssuerID) }}" alt="Issuer Signature">
    */
});

Route::fallback(function () {
    return view('errors.404');
});