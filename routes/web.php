<?php

use App\Http\Controllers\assignment;
use App\Http\Controllers\Course;

use App\Http\Controllers\enrollments;
use App\Http\Controllers\module;

use App\Http\Controllers\modules;
use App\Http\Controllers\RBAC;
use App\Http\Controllers\submissions;
use App\Models\Enrollment;
use App\Models\Submission;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
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
        Route::post('/modules', [module::class, 'store']);
    });
});
Route::get('/courses/module', function () {
    return view('dashboard.faculty.modulepost');
})->name('createmodule');



Route::get('/testing', function () {
    return view('test');
})->name('testing');



// View routes

    // Route for individual courses by course ID 
    // Faculty View
    Route::get('/courses/id/{courseID}', [Course::class, 'getCourseByCourseID'])->name('course.course');
    Route::get('/courses/classwork/id/{courseID}', [Course::class, 'classwork'])->name('course.classwork');
    Route::get('/courses/submissions/id/{courseID}', [Course::class, 'submission'])->name('course.submission');
    Route::get('/courses/settings/id/{courseID}', [Course::class, 'settings'])->name('course.settings');
    

// Data routes
    // Route for courses by faculty
    Route::get('courses/get/{facultyID}', [Course::class, 'getCoursesByFaculty']);
    Route::post('modules/post', [modules::class, 'store'])->name('module');
    Route::post('modules/update', [modules::class, 'update'])->name('module.update');;
    // Route::post('modules/{courseId}', [module::class, 'createModule'])->name('module.post');
    Route::post('modules/delete', [modules::class, 'delete'])->name('module.delete');
    Route::post('course/delete', [Course::class, 'deleteCourse'])->name('course.delete');
    Route::post('course/update', [Course::class, 'updatecourse'])->name('course.update');

    // assignments
    Route::post('assignment/post', [assignment::class, 'store'])->name('assignment.post');
    Route::post('assignment/update', [assignment::class, 'update'])->name('assignment.update');
    Route::post('assignment/delete', [assignment::class, 'delete'])->name('assignment.delete');

    // submission - Faculty
    Route::post('submission/grade', [submissions::class, 'grade'])->name('submission.grade');
    // submission - Student
    Route::post('submission/post', [submissions::class, 'insert'])->name('submission.post');
    // 

    // enrollment 
    Route::post('/enrollment', [enrollments::class, 'getCoursesByStudent'])->name('enrollment');


    
    


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