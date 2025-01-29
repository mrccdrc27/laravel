<?php


use App\Http\Controllers\Api\CertificationsController;
use App\Http\Controllers\IssuersController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// GET http://127.0.0.1:8000/api/cert/verify/CERT-001
Route::get('cert/verify/{code}', [CertificationsController::class, 'verifyCertificate']);

Route::apiResource('user_info', UsersController::class);
Route::apiResource('issuer', IssuersController::class);
Route::apiResource('org', OrganizationsController::class);




// Example: GET: http://127.0.0.1:8000/search/cert?firstName=Jane&lastName=Lee Returns JSON response
Route::get('search/cert', [CertificationsController::class, 'showname']);

Route::apiResource('cert', CertificationsController::class);
// For retrieving certification details (show()):
/* GET http://127.0.0.1:8000/api/cert/{id}
Response: 
{
  "success": true,
  "data": {
    "certificationID": "1",
    "certificationNumber": "CERT-001",
    "courseID": "1",
    "title": "Introduction to Computer Science Certification",
    "description": "Certification for completing Introduction to Computer Science course.",
    "issuedAt": "2025-01-27 21:12:04.740",
    "expiryDate": "2026-01-27",
    "userID": "3",
    "created_at": "2025-01-27 21:12:04.740",
    "updated_at": "2025-01-27 21:12:04.740",
    "issuerFirstName": "Burt",
    "issuerLastName": "Goodman",
    "issuerID": "1",
    "organizationName": "Lumon Industries"
  },
  "certificateLink": "http://127.0.0.1:8000/cert/details/1"
}
*/


Route::get('search/cert', [CertificationsController::class, 'showname']);
// Example: GET: http://127.0.0.1:8000/api/search/cert?firstName=Jane&lastName=Lee



Route::get('certification-count', [CertificationsController::class, 'getCertificationCount'])->name('getCertificationCount');

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


