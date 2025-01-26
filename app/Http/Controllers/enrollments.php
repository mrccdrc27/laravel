<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class enrollments extends Controller
{
    public function getCoursesByStudent(Request $request)
    {
        $request->validate([
            'courseID' => 'required|integer|max:100',
        ]);
        // // Ensure $courseID is cast to a BIGINT (integer in PHP)
        // $courseID = $request->courseID;
        $isAcive = 1;

        DB::statement('EXEC InsertEnrollment ?,?,?', [
            $request->input('courseID'),
            $request->input('studentID'), 
            //is active = 1
            $isAcive
        ]);
        return redirect()->back()->with('success', 'enrolled successfully.');
        // redirect to the course
    }
}
