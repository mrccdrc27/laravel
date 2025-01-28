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
            'oldgrade' => 'nullable|integer'
        ]);

        $grade = $request->input('oldgrade');

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

    public function update(Request $request)
    {
         // Validate incoming request
         $request->validate([
            'submissionID' => 'required|integer|exists:submissions,submissionID',
            'assignmentID' => 'required|integer|exists:assignments,assignmentID',
            //student ID from Auth
            'content' => 'nullable|required',
            'file' => 'nullable|file|max:10240', // Optional file, adjust size if needed
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            // Check if there is an old file and delete it from the storage
            if ($request->has('oldfile') && $request->oldfile && !filter_var($request->oldfile, FILTER_VALIDATE_URL)) {
                $oldFilePath = storage_path('app/public/' . $request->oldfile);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath); // Delete the old file
                }
            }
            // Store the new file in the 'modules' folder on the 'public' disk
            $file = $request->file('file');
            // This will return the relative path (e.g., 'modules/filename.extension')
            $filePath = $file->store('submissions', 'public');
        }

        $content = null;
        if ($request->has('content')){
            $content = $request->input('content');
        }


                
        // Call the stored procedure
        DB::statement('EXEC updateSubmission ?, ?, ?, ?, ?, ?', [
            $request->input('submissionID'),
            $request->input('assignmentID'),
            auth()->user()->id, 
            $content,
            $filePath,
            $request->input('grade'),
        ]);
        return redirect()->back()->with('success', 'Submission updated successfully.');
    }

    
    public function delete(Request $request){

        DB::statement('EXEC deleteSubmission ?', [
            $request->input('submissionID')
        ]);
        return redirect()->back()->with('success', 'Submission deleted successfully.');
    }
}
