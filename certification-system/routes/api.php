<?php

use App\Http\Controllers\Api\V1\CertificationController;

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

    Route::apiResource('certifications', CertificationController::class);
    
});
# API or Web Routes? (GenerateQR is a API json response method)
Route::get('/certifications/{id}/generate-qr',[CertificationController::class,'GenerateQR']);


