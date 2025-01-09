<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('user/{id}/profile', [UserController::class, 'showProfile']);

Route::get('user/search', [UserController::class, 'search']);
