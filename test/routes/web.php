<?php

use App\Http\Controllers\corecontroller;
use App\Http\Controllers\ToyController;

Route::get('/toys', [ToyController::class, 'index']);

Route::get('/core', [corecontroller::class, 'index']);