<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CertificationController;
use App\Http\Controllers\display;
use App\Http\Controllers\Api\V1\IssuerInformationController;



Route::get('certificate', function () {
    return view('dashboard.certificate');
})->name('certificate');

// Route::get('home', function () {
//     return view('dashboard.home');
// })->name('home');
// Route::get('home', function () {
//     return view('dashboard.home');
// });
Route::get('home', [display::class, 'count'])->name('home');
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



// // Certification Routes
// Route::prefix('certifications')->name('certifications.')->group(function () {
//     Route::get('/{id}/qr-code', [CertificationController::class, 'showQR'])->name('qr-code');
// });

// // Issuer Information Routes
// Route::prefix('issuers')->name('issuers.')->group(function () {
//     Route::get('/{id}/details', [IssuerInformationController::class, 'showDetails'])->name('details');
//     // Asset routes
//     Route::get('/{id}/logo', [IssuerInformationController::class, 'getLogo'])->name('logo');
//     Route::get('/{id}/signature', [IssuerInformationController::class, 'getSignature'])->name('signature');
    
//     /* Example in a view:
//     <img src="{{ route('issuers.signature', $issuer->IssuerID) }}" alt="Issuer Signature">
//     */
// });


Route::fallback(function () {
    return view('errors.404');
});