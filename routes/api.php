<?php


use App\Http\Controllers\CertificationsController;
use App\Http\Controllers\IssuerInformationController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserInfoController;
use App\Models\user_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::get('/', function(){
// return 'API';
// });


// Public routes
Route::get('search/cert', [CertificationsController::class, 'showname']);

// Protected routes
Route::middleware(['auth:sanctum', 'integrated.systems'])->group(function () {
    // User routes
    Route::apiResource('user_info', UserInfoController::class);
    
    // Certification System routes
    Route::prefix('certification')->group(function () {
        Route::apiResource('issuer', IssuerInformationController::class);
        Route::apiResource('org', OrganizationController::class);
        Route::apiResource('cert', CertificationsController::class);
    });
});


// use App\Http\Controllers\Api\V1\CertificationController;
// use App\Http\Controllers\Api\V1\IssuerInformationController;


// # https://laravel.com/docs/11.x/routing 


// #https://laravel.com/docs/11.x/routing#route-groups





// /**
//  * Certification API Routes
//  * 
//  * @link https://laravel.com/docs/11.x/controllers#api-resource-routes API Resource Routes Documentation
//  * @link https://dev.to/johndivam/laravel-routes-apiresource-vs-resource-ij5 API Resource vs Resource Comparison
//  * 
//  * Automatically generates the following RESTful endpoints:
//  * 
//  * GET    /v1/certifications          - index()   : List all certifications
//  * POST   /v1/certifications          - store()   : Create a new certification
//  * GET    /v1/certifications/{id}     - show()    : Retrieve a specific certification
//  * PUT    /v1/certifications/{id}     - update()  : Update a specific certification
//  * DELETE /v1/certifications/{id}     - destroy() : Delete a specific certification
//  * 
//  * @package App\Http\Controllers\Api
//  * @uses CertificationController
//  */
// Route::prefix('v1')->group(function () {
//     Route::middleware(['auth:api', 'lms.auth'])->group(function () {
//         Route::apiResource('certifications', CertificationController::class)
//             ->except(['index', 'show']); // Public access to view certificates
//     });
//     Route::apiResource('issuers', IssuerInformationController::class);
//     Route::get('issuers/{id}/logo', [IssuerInformationController::class, 'getLogo']);
//     Route::get('issuers/{id}/signature', [IssuerInformationController::class, 'getSignature']);
//     Route::get('certifications', [CertificationController::class, 'index']);
//     Route::get('certifications/{id}', [CertificationController::class, 'show']);
// });


