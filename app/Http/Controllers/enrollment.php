<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class enrollment extends Controller
{
    public function create(Request $request)
    {
        // Validate the input (courseID and studentID)
    $request->validate([
        'course_id' => 'required|exists:courses,courseID',
        'student_id' => 'required|exists:users,id',
    ]);

    try {
        // Call the stored procedure to create the enrollment
        DB::statement('EXEC CreateEnrollment ?, ?', [
            $request->course_id,  // Course ID
            $request->student_id, // Student ID
        ]);

        return redirect()->back()->with('success', 'Enrollment created successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred: invalid input');
    }
    }
}
