<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CertificationController;
use App\Http\Controllers\display;
use App\Http\Controllers\Api\V1\IssuerInformationController;
use App\Http\Controllers\DashboardController;

Route::get('home', function () {
    return view('test');
})->name('home');
Route::get('/', function () {
    return view('test');
});



// Public routes
// Route::get('/', function () {
//     return redirect()->route('home');
// });

Route::get('about', function () {
    return view('dashboard.about');
})->name('about');

Route::get('search', function () {
    return view('dashboard.search');
})->name('search');

// Protected routes
Route::middleware(['auth:sanctum', 'integrated.systems'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/counts', [DashboardController::class, 'counts'])->name('dashboard.counts');
    Route::get('dashboard/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');
});

    // Certificate routes
    Route::prefix('certificate')->name('certificate.')->group(function () {
        Route::get('/', function () {
            return view('dashboard.certificate');
        });

        Route::get('/user', function () {
            return view('dashboard.cert.user');
        })->name('user');

        Route::get('/issuer', function () {
            return view('dashboard.cert.issuer');
        })->name('issuer');

        Route::get('/org', function () {
            return view('dashboard.cert.org');
        })->name('org');

        Route::get('/create', function () {
            return view('dashboard.cert.create');
        })->name('create');
    });

// Fallback route
Route::fallback(function () {
    return view('errors.404');
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
    return view('errors.404');
});