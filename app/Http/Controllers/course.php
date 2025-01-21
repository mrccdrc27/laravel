<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class course extends Controller
{
    /**
     * Get courses by faculty ID.
     *
     * @param  int  $facultyID
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCoursesByFaculty($facultyID)
    {
        // Call the stored procedure 'GetCoursesByFaculty' to retrieve courses by facultyID
        $courses = DB::select('EXEC GetCoursesByFaculty ?', [$facultyID]);

        // Return the courses as a JSON response
        return response()->json($courses);
    }

    public function getCourseByCourseID($courseID)
    {
        try {
            // Call the stored procedure and pass the courseID parameter
            $course = DB::select('EXEC GetCourseByCourseID @CourseID = ?', [$courseID]);
            
            // Check if the course exists
            if (empty($course)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Course not found',
                ], 404);
            }

            // Return the course data as json
            // return response()->json([
            //     'success' => true,
            //     'data' => $course[0],
            // ]);

            // // Return the course data as view
            $course = $course[0]; // Now $course is an object
            return view('dashboard.faculty.courseview',compact('course'));


        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching the course',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function createCourse(Request $request)
    {
        // Validate the input
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string',
        ]);
        try {
            // Call the stored procedure
            DB::statement('EXEC CreateCourse ?, ?, ?', [
                auth()->user()->id,          // User ID
                $request->input('title'),     // Course name
                $request->input('description') // Course description
            ]);

            return redirect()->back()->with('success', 'Course created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function showCreateCourseForm()
{
    // Check if the user has the 'faculty' role
    if (auth()->user()->role !== 'faculty') {
        return redirect('/')->with('error', 'Access denied. Only faculty can create courses.');
    }

    // Return the view for the course creation form
    return view('components.createCourse');
}
}
