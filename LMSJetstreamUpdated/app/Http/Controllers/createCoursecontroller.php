<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class createCoursecontroller extends Controller
{

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
    return view('faculty.createCourse');
}


}
