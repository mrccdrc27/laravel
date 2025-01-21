<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;

class modules extends Controller
{
    /**
     * Store a new module.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
         // Validate incoming request
         $request->validate([
            'course_id' => 'required|integer|exists:courses,courseID',
            'title' => 'required|string|max:100',
            'content' => 'required|string',
            'file' => 'nullable|file|max:10240', // Optional file, adjust size if needed
        ]);

        // Handle file upload if present
        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Store the file in Laravel's storage and get the file path
            $filePath = $file->store('modules', 'public'); // Stored in 'storage/app/public/modules'
            $filePath = Storage::disk('public')->path($filePath);
        }
 
        // Call the stored procedure
        DB::statement('EXEC createModule ?, ?, ?, ?', [
            $request->input('course_id'),
            $request->input('title'),
            $request->input('content'),
            $filePath,
        ]);
        return redirect()->back()->with('success', 'Course created successfully.');

        // Return success response
        // return response()->json([
        //     'message' => 'Module created successfully.',
        //     'file_path' => $filePath, // This will return null if no file was uploaded
        // ]);
    }
}
