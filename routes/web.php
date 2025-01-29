<?php

use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\WebCertificateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CertificationsController;
use App\Http\Controllers\DisplaysController;
use App\Http\Controllers\IssuersController;
use App\Http\Controllers\TestsControllers;

// Route::get('home', [DisplaysController::class, 'count'])->name('home');

Route::get('api-doc', function () {
    return view('dashboard.api-doc');
})->name('api-doc');

Route::get('/', function () {
    return view('dashboard.home');
})->name('home');


// For web certificates (made in the site)
Route::post('/web-certificates', [WebCertificateController::class, 'store'])->name('web.certificates.store');
Route::get('/web-certificates/{id}', [WebCertificateController::class, 'show'])->name('web.certificates.show');
Route::get('/web-check/{id}', [WebCertificateController::class, 'getWebCertificationCount'])->name('web.certificates.count');

Route::get('/org', [IssuersController::class, 'showOrganizationsWithIssuers'])->name('org');

Route::get('certifications/count', [CertificationsController::class, 'getCertificationCount']);

// Example: GET: http://127.0.0.1:8000/search/cert?firstName=Jane&lastName=Lee
Route::get('search/cert', [CertificationsController::class, 'showname']);


Route::view('/certifications/create', 'components.create')->name('certifications.create');

Route::get('cert/details/{id}', [CertificationsController::class, 'getByID'])->name('cert.details');


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
