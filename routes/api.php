<?php

use App\Http\Controllers\coursecontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


route::apiResource('course', coursecontroller::class);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:admin|student|faculty',
])->group(function () {
    route::apiResource('course', coursecontroller::class);
});


