<?php

use App\Http\Controllers\Api\V1\CertificationController;

# https://laravel.com/docs/11.x/routing 


#https://laravel.com/docs/11.x/routing#route-groups




Route::prefix('v1')->group(function () {
    #https://laravel.com/docs/11.x/controllers#api-resource-routes
    Route::apiResource('certifications', CertificationController::class); # Automatic REST API endpoints
    
});
# API or Web Routes? (GenerateQR is a API json response method)
Route::get('/certifications/{id}/generate-qr',[CertificationController::class,'GenerateQR']);


