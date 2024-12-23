<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CertificationController;


// Route::get('/', function () {
//     return view('welcome');
// });



Route::get('/certifications/{id}/qr-code', [CertificationController::class, 'showQR'])->name('certifications.qr-code');

//added CS UI
use App\Http\Controllers\certview;
Route::get('/', [Certview::class, 'showDashboard'])->name('home'); // Route for Dashboard (Home)
Route::get('/certificate', [Certview::class, 'showCertificate'])->name('certificate'); // Route for Certificate page
Route::get('/search', [Certview::class, 'searchCertificate'])->name('search'); // Route for Search Certificate page



