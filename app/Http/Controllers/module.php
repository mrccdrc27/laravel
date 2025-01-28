<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class module extends Controller
{

    public function createModule(Request $request, $courseId)
    {
    // Validate the input
    // $request->validate([
    //     'title' => 'required|string|max:100',
    //     'description' => 'nullable|string|max:1000',
    //     'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Optional file validation
    // ]);

    // Get file data as binary (BLOB)
    // $fileData = $request->hasFile('file') 
    //     ? file_get_contents($request->file('file')->getRealPath()) 
    //     : null;

    try {
        // Call the stored procedure
        // DB::statement('EXEC CreateModuleForCourse @Name = ?, @Description = ?, @CourseID = ?', [
        //     $request->input('title'),
        //     $request->input('description'),
        //     $courseId,
        // ]);

        DB::statement('EXEC CreateModuleForCourse @Name = ?, @Description = ?, @CourseID = ?', [
            $request->input('title'),
            $request->input('description'),
            $courseId,
        ]);

        return redirect()->route('courses.show', $courseId)->with('success', 'Module created successfully!');
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Failed to create module: ' . $e->getMessage()]);
        }
    }


    // public function showCreateModuleForm($courseId)
    // {
    //     // Check if the course exists and the current user is the creator
    //     $course = DB::table('Courses')->where('courseID', $courseId)
    //         ->where('facultyID', Auth::id())
    //         ->first();

    //     if (!$course) {
    //         return redirect()->route('dashboard')->withErrors('You are not authorized to add modules to this course.');
    //     }

    //     return view('components.createModule', ['course' => $course]);
    // }




}
