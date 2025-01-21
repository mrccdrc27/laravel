<?php

use App\Http\Controllers\Course;
use App\Http\Controllers\modules;
use App\Http\Controllers\RBAC;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/register-faculty', function () {
    return view('auth.register-faculty');
})->name('register-faculty');

// Home route
Route::get('/home', [RBAC::class, 'index'])->name('home');

// Routes requiring authentication and role-based access
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Routes for admin role only
    Route::middleware('role:admin')->group(function () {
        Route::get('/core', function () {
            return view('dashboard.student.submission');
        })->name('core');

        Route::get('/managefaculty', function () {
            return view('dashboard.admin.CreateFaculty');
        })->name('managefaculty');
    });

    // Routes for admin, student, or faculty roles
    Route::middleware('role:admin|student|faculty')->group(function () {
        Route::get('/Courses', [RBAC::class, 'Courses'])->name('Courses');

        // Route for courses by faculty
        Route::get('courses/faculty/{facultyID}', [Course::class, 'getCoursesByFaculty']);

        // Route for courses by course ID
        Route::get('/courses/id/{courseID}', [Course::class, 'getCourseByCourseID']);

        // Routes for faculty to create courses
        Route::get('/faculty/createCourse', [Course::class, 'showCreateCourseForm'])->name('components.CreateCourseForm');
        Route::post('/faculty/createCourse', [Course::class, 'createCourse'])->name('components.createCourse');

        // Routes to show view to create course
        Route::get('/courses/create/', function () {
            return view('dashboard.faculty.createcourse');
        })->name('coursescreate');

        

        //Module Routes
            // store
        Route::post('/modules', [modules::class, 'store']);
    });
});
Route::get('/courses/module', function () {
    return view('dashboard.faculty.modulepost');
})->name('createmodule');



Route::get('/testing', function () {
    return view('dashboard.faculty.modulepost');
})->name('testing');
