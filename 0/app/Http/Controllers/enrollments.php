<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class enrollments extends Controller
{
    public function getCoursesByStudent(Request $request)
    {
        $request->validate([
            'courseID' => 'required|string|max:100',
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

    public function test(Request $request){
        return 10;
    }

    public function delete(Request $request){
        // $request->validate([
        //     'enrollmentID' => 'required|integer|exists:enrollment,enrollmentID'
        // ]);
        
        try {
            DB::statement('EXEC DeleteEnrollment ?', [
                $request->input('enrollmentID'),
            ]);
            return redirect()->route('Courses')->with('success', 'has leaved the course successfully.');


        } catch (ValidationException $e) {
            // Return unsuccessful error if validation fails
            return redirect()->back()->with('failure', 'Invalid Procedure');
        }
    }
}
