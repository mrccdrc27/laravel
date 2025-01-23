<?php

use App\Http\Controllers\Course;

use App\Http\Controllers\module;
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
        Route::get('courses/get/{facultyID}', [Course::class, 'getCoursesByFaculty']);

        // Route for courses by course ID
        Route::get('/courses/id/{courseID}', [Course::class, 'getCourseByCourseID']);

        // Routes for faculty to create courses
        Route::get('/faculty/createCourse', [Course::class, 'showCreateCourseForm'])->name('components.CreateCourseForm');
        Route::post('/faculty/createCourse', [Course::class, 'createCourse'])->name('components.createCourse');

        // Routes to show view to create course
        Route::get('/courses/create/', function () {
            return view('dashboard.faculty.createcourse');
        })->name('coursescreate');

        //Routes for creating modules
        // Route::get('/courses/{courseId}/modules', [module::class, 'index'])->name('modules.index');
        Route::get('/courses/{courseId}/components/createModule', [module::class, 'showCreateModuleForm'])->name('components.CreateModuleForm');
        Route::post('/courses/{courseId}/components/createModule', [module::class, 'createModule'])->name('components.createModule');
    

        // Routes to delete course
        Route::post('/delete-course', [course::class, 'deleteCourse']);

        

        //Module Routes
            // store
        // Route::post('/modules', [modules::class, 'store']);
    });
});
Route::get('/courses/module', function () {
    return view('dashboard.faculty.modulepost');
})->name('createmodule');



Route::get('/testing', function () {
    return view('test');
})->name('testing');


// Data routes:

    // Route for courses by faculty
    Route::get('courses/get/{facultyID}', [Course::class, 'getCoursesByFaculty']);


// Form Routes

Route::middleware('role:admin|student|faculty')->group(function () {

    // Create Courses
    Route::get('/faculty/courses/create', function () { return view('dashboard.faculty.faculty');})
    ->name('faculty.courses.create');
    // Update Course
    Route::get('/faculty/courses/update', function () { return view('dashboard.faculty.faculty');})
    ->name('faculty.courses.update');

    Route::post('/faculty/modules/insert', function () { return 'faculty.modules.insert'; })->name('faculty.modules.insert');
    
    Route::get('/modules/read', function () { return 'modules.read'; })->name('modules.read');
    
    Route::post('/faculty/modules/update', function () { return 'faculty.modules.update'; })->name('faculty.modules.update');
    
    Route::post('/faculty/modules/delete', function () { return 'faculty.modules.delete'; })->name('faculty.modules.delete');
    
    Route::post('/faculty/assignment/insert', function () { return 'faculty.assignment.insert'; })->name('faculty.assignment.insert');
    
    Route::get('/assignment/read', function () { return 'assignment.read'; })->name('assignment.read');
    
    Route::post('/faculty/assignment/update', function () { return 'faculty.assignment.update'; })->name('faculty.assignment.update');
    
    Route::post('/faculty/assignment/delete', function () { return 'faculty.assignment.delete'; })->name('faculty.assignment.delete');
    
    Route::post('/enrollment/delete', function () { return 'enrollment.delete'; })->name('enrollment.delete');
    
    Route::get('/faculty/enrollment/read', function () { return 'faculty.enrollment.read'; })->name('faculty.enrollment.read');
    
    Route::post('/faculty/enrollment/delete', function () { return 'faculty.enrollment.delete'; })->name('faculty.enrollment.delete');
    
    Route::post('/course/insert', function () { return 'course.insert'; })->name('course.insert');
    
    Route::get('/course/read', function () { return 'course.read'; })->name('course.read');
    
    Route::post('/faculty/course/update', function () { return 'faculty.course.update'; })->name('faculty.course.update');
    
    Route::post('/faculty/course/delete', function () { return 'faculty.course.delete'; })->name('faculty.course.delete');
    
});

// data routes


// temp routes

Route::middleware('role:admin|student|faculty')->group(function () {
    Route::get('faculty/courses', function () { return 'faculty.courses'; })->name('faculty.courses');    
    Route::get('courses/join', function () { return 'courses'; })->name('courses.join');    

});