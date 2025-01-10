<?php
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\AssessmentController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\Api\V1\AuthController;
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
 * 
 */

Route::prefix('v1')->group(function () {
    Route::apiResource('user', UserController::class);
    Route::apiResource('assessments', AssessmentController::class);

    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
    Route::put('change-password', [AuthController::class, 'changePassword']);
});




