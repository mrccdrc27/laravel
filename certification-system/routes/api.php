<?php

use App\Http\Controllers\Api\V1\CertificationController;

# https://laravel.com/docs/11.x/routing 


#https://laravel.com/docs/11.x/routing#route-groups



Route::group(['prefix' => 'V1'], function () {
    #https://laravel.com/docs/11.x/controllers#api-resource-routes
    Route::apiResource('certifications', CertificationController::class); # Automatic REST API endpoints
});


