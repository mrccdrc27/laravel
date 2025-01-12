<?php

use App\Http\Controllers\IssuerInformationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserInfoController;
use App\Models\user_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::get('/', function(){
// return 'API';
// });

Route::apiResource('user_info', UserInfoController::class);


