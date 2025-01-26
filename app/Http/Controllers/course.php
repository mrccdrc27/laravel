<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
// use app\Http\Controllers\modules;

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

    public function getCoursesByStudent(Request $request)
    {
        // Ensure $courseID is cast to a BIGINT (integer in PHP)
        $studentID = $request->studentID;

        // Execute the stored procedure with the courseID parameter
        $course = DB::select('EXEC GetStudentCourses @student_id = ?', bindings: [$studentID]);

        return view('dashboard.student.courses', compact('course')); 
    }

    // View Courses

    public function getCourseByCourseID($courseID)
    {
        // call instance of modules controller
        
        try {
            // Call the stored procedure and pass the courseID parameter
            $course = DB::select('EXEC GetCourseByCourseID @CourseID = ?', [$courseID]);
            $modules = DB::select('EXEC GetModulesByCourse :courseID', ['courseID' => $courseID]);
            
            // Check if the course exists
            if (empty($course)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Course not found',
                ], 404);
            }
            $course = $course[0]; // Now $course is an object
            return view('dashboard.faculty.courseview',compact('course','modules'));
            
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching the course',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function classwork (Request $request){
        // Ensure $courseID is cast to a BIGINT (integer in PHP)
        $courseID = $request->courseID;

        // Execute the stored procedure with the courseID parameter
        $course = DB::select('EXEC GetCourseByCourseID @CourseID = ?', [$courseID]);
        $assignment = DB::select('EXEC GetCourseAssignments @CourseID = ?', [$courseID]);

        // Return the view with the course data
        $course = $course[0]; 
        return view('dashboard.faculty.courseviewclasswork', compact('course','assignment')); 
    }
    public function submission(Request $request)
    {
        // Ensure $courseID is cast to a BIGINT (integer in PHP)
        $courseID = $request->courseID;

        // Execute the stored procedure with the courseID parameter
        $course = DB::select('EXEC GetCourseByCourseID @CourseID = ?', [$courseID]);

        if (Auth::user()->hasRole('student')) {
            $studentID = Auth::user()->id;
            $assignment = DB::select('EXEC GetStudentSubmissions @studentID = ?', [$studentID]);
        } 
        if (Auth::user()->hasRole('faculty')){
            $assignment = DB::select('EXEC GetStudentAssignmentsByCourse @CourseID = ?', [$courseID]);
        }
        // Return the view with the course data
        $course = $course[0]; 
        return view('dashboard.faculty.courseviewsubmission', compact('course', 'assignment'));
    }
    public function settings (Request $request){
        // Ensure $courseID is cast to a BIGINT (integer in PHP)
        $courseID = $request->courseID;

        // Execute the stored procedure with the courseID parameter
        $course = DB::select('EXEC GetCourseByCourseID @CourseID = ?', [$courseID]);

        // Return the view with the course data
        $course = $course[0]; 
        return view('dashboard.faculty.courseviewsettings', compact('course'));
    }


    // End of View Courses

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

    public function updatecourse(Request $request)
    {
        $request->validate([
            'courseID' => 'required|integer|exists:courses,courseID',
        ]);

        // Call the stored procedure
        DB::statement('EXEC updateCourse ?,?,?', [
            $request->input('courseID'),
            $request->input('title'), 
            $request->input('description')
        ]);
        return redirect()->back()->with('success', 'course updated successfully');
    }
    public function deleteCourse(Request $request)
        {
            $request->validate([
                'courseID' => 'required|integer|exists:courses,courseID',
            ]);
        
            // Call the stored procedure
            DB::statement('EXEC DeleteCourse ?', [
                $request->input('courseID')
            ]);
        
            // Redirect to a specific route (e.g., course list page)
            return redirect()->route('Courses')->with('success', 'Course deleted successfully');
        }
        

}
