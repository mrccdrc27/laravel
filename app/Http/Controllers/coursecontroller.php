<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class coursecontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($facultyID)
    {
        // Call the stored procedure 'GetCoursesByFaculty' to retrieve courses by facultyID
        $courses = DB::select('EXEC GetCoursesByFaculty ?', [$facultyID]);

        // Return the courses as a JSON response
        return response()->json($courses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $facultyID)
    {
        // Call the stored procedure 'GetCoursesByFaculty' to retrieve courses by facultyID
        $courses = DB::select('EXEC GetCoursesByFaculty ?', [$facultyID]);

        // Return the courses as a JSON response
        return response()->json($courses);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
