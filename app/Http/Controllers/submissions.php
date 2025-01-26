<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Illuminate\Validation\ValidationException;

use Illuminate\Http\Request;

class submissions extends Controller
{
    public function grade(Request $request)
    {
         // Validate incoming request
         $request->validate([
            'submissionID' => 'required|integer|exists:submissions,submissionID',
            'grade' => 'nullable|integer', // Optional file, adjust size if needed
        ]);

        try {
            DB::statement('EXEC updateSubmissionGrade ?, ?', [
                $request->input('submissionID'),
                $request->input('grade'),
            ]);
            return redirect()->back()->with('success', 'grades updated successfully.');

        } catch (ValidationException $e) {
            // Return unsuccessful error if validation fails
            return redirect()->back()->with('failure', 'Invalid Procedure');
        }
    }

    public function insert(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'assignmentID' => 'required|integer|exists:assignments,assignmentID',
            'content' => 'nullable|max:4000',
            'file' => 'nullable|file|max:10240', // Optional file, adjust size if needed
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('submissions', 'public');
        }
        $grade = null;
        if ($request->has('grade')){
            $grade = $request->input('grade');
        }
        $content = null;
        if ($request->has('content')){
            $content = $request->input('content');
        }
                
        // Call the stored procedure
        DB::statement('EXEC createSubmission ?, ?, ?, ?, ?', [
            $request->input('assignmentID'),
            auth()->user()->id,  
            $content,
            $filePath,
            $grade
        ]);
        return redirect()->back()->with('success', 'assignment submitted successfully.');
    }

    
}
