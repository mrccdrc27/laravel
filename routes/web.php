<?php

use App\Http\Controllers\course;
use App\Http\Controllers\RBAC;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register-faculty', function () {
    return view('auth.register-faculty');
})->name('register-faculty');

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });
// Route::get('/core', function () {
//     return view('dashboard.student.submission');
// });


Route::get('/home', [RBAC::class, 'index'])->name('home');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:admin',
])->group(function () {
    Route::get('/core', function () {
        return view('dashboard.student.submission');
    })->name('core');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:admin',
])->group(function () {
    Route::get('/managefaculty', function () {
        return view('dashboard.admin.CreateFaculty');
    })->name('managefaculty');
});

//middleware

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:admin|student|faculty',
])->group(function () {
    Route::get('/Courses', [RBAC::class, 'Courses'])->name('Courses');;
});

// simple
// Route::get('courses/faculty/{facultyID}', [course::class, 'getCoursesByFaculty']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:admin|student|faculty',
])->group(function () {
    Route::get('courses/faculty/{facultyID}', [course::class, 'getCoursesByFaculty']);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:admin|student|faculty',
])->group(function () {
    Route::get('/courses/id/{courseID}', [course::class, 'getCourseByCourseID']);
});






