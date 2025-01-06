<?php

use App\Http\Controllers\Api\V1\UserInfoController;
use App\Http\Controllers\Api\V1\UserController;

/**
 * Certification API Routes
 * 
 * @link https://laravel.com/docs/11.x/controllers#api-resource-routes API Resource Routes Documentation
 * @link https://dev.to/johndivam/laravel-routes-apiresource-vs-resource-ij5 API Resource vs Resource Comparison
 * 
 * Automatically generates the following RESTful endpoints:
 * 
 * GET         - index()
 * POST        - store()
 * GET         - show()
 * PUT         - update()
 * DELETE      - destroy()
 * 
 * @package App\Http\Controllers\Api
 * @uses UserController
 */

Route::prefix('v1')->group(function () {
    Route::apiResource('user', UserController::class);
});






