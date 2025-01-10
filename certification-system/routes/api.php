<?php

use App\Http\Controllers\Api\V1\CertificationController;
use App\Http\Controllers\Api\V1\IssuerInformationController;


# https://laravel.com/docs/11.x/routing 


#https://laravel.com/docs/11.x/routing#route-groups





/**
 * Certification API Routes
 * 
 * @link https://laravel.com/docs/11.x/controllers#api-resource-routes API Resource Routes Documentation
 * @link https://dev.to/johndivam/laravel-routes-apiresource-vs-resource-ij5 API Resource vs Resource Comparison
 * 
 * Automatically generates the following RESTful endpoints:
 * 
 * GET    /v1/certifications          - index()   : List all certifications
 * POST   /v1/certifications          - store()   : Create a new certification
 * GET    /v1/certifications/{id}     - show()    : Retrieve a specific certification
 * PUT    /v1/certifications/{id}     - update()  : Update a specific certification
 * DELETE /v1/certifications/{id}     - destroy() : Delete a specific certification
 * 
 * @package App\Http\Controllers\Api
 * @uses CertificationController
 */
Route::prefix('v1')->group(function () {
    Route::middleware(['auth:api', 'lms.auth'])->group(function () {
        Route::apiResource('certifications', CertificationController::class)
            ->except(['index', 'show']); // Public access to view certificates
    });
    Route::apiResource('issuers', IssuerInformationController::class);
    Route::get('issuers/{id}/logo', [IssuerInformationController::class, 'getLogo']);
    Route::get('issuers/{id}/signature', [IssuerInformationController::class, 'getSignature']);
    Route::get('certifications', [CertificationController::class, 'index']);
    Route::get('certifications/{id}', [CertificationController::class, 'show']);
});

