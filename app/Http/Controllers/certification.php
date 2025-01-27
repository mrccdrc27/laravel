<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class certification extends Controller
{
    public function certification (Request $request){
        $courseID = $request->courseID;

        // Execute the stored procedure with the courseID parameter
        $course = DB::select('EXEC GetCourseByCourseID @CourseID = ?', [$courseID]);
        //$assignment = DB::select('EXEC GetCourseAssignments @studentID = ?,@CourseID = ?', [auth()->user()->id,$courseID]);
        // Return the view with the course data
        $course = $course[0]; 
        return view('dashboard.faculty.courseviewcertificate', compact('course'));
    }
}
