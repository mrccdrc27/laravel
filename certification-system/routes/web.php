<?php

use App\Http\Controllers\OrganizationsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CertificationsController;
use App\Http\Controllers\DisplaysController;
use App\Http\Controllers\Api\V1\IssuersController;
use App\Http\Controllers\TestsControllers;

// Route::get('home', [DisplaysController::class, 'count'])->name('home');

Route::get('certificate', function () {
    return view('dashboard.certificate');
})->name('certificate');

Route::get('/', function () {
    return view('dashboard.home');
})->name('home');

Route::get('/api/certifications/count', [CertificationsController::class, 'getCertificationCount']);
// Route::get('home', function () {
//     return view('dashboard.home');
// })->name('home');
// Route::get('home', function () {
//     return view('dashboard.home');
// });

Route::get('/api/certification-count', [CertificationsController::class, 'getCertificationCount'])->name('getCertificationCount');
Route::get('cert/details/{id}', [CertificationsController::class, 'getByID'])->name('cert.details');


Route::get('about', function () {
    return view('dashboard.about');
})->name('about');

Route::get('search', function () {
    return view('dashboard.search');
})->name('search');

Route::get('org', function () {
    return view('dashboard.org');
})->name('org');

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

// routes/web.php or routes/api.php
Route::get('organizations/create-test', [OrganizationsController::class, 'createTestOrganization']);


Route::prefix('test')->group(function () {
    // Test route for certificate not found error
    Route::get('certificate-not-found', [TestsControllers::class, 'testCertificateNotFound'])->name('test.certificate_not_found');

    // Test route for a generic error
    Route::get('generic-error', [TestsControllers::class, 'testGenericError'])->name('test.generic_error');
    // http://127.0.0.1:8000/test/generic-error
});

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
    return view('errors.generic_error');
});