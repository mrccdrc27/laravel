<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Illuminate\Validation\ValidationException;

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

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // Store the file in 'modules' folder on the 'public' disk
            // This will return the relative path (e.g., 'modules/filename.extension')
            $filePath = $file->store('modules', 'public');
        }
                
        // Call the stored procedure
        DB::statement('EXEC createModule ?, ?, ?, ?', [
            $request->input('course_id'),
            $request->input('title'),
            $request->input('content'),
            $filePath,
        ]);
        return redirect()->back()->with('success', 'Module created successfully.');
    }

    public function update(Request $request)
    {
         // Validate incoming request
         $request->validate([
            'course_id' => 'required|integer|exists:courses,courseID',
            'title' => 'required|string|max:100',
            'content' => 'required',
            'moduleID' => 'required|integer|exists:modules,moduleID',
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
            $filePath = $file->store('modules', 'public');
        }
                
        // Call the stored procedure
        DB::statement('EXEC updateModule ?, ?, ?, ?, ?', [
            $request->input('moduleID'),
            $request->input('course_id'),
            $request->input('title'),
            $request->input('content'),
            $filePath,

        ]);
        return redirect()->back()->with('success', 'Module updated successfully.');
    }

    public function delete(Request $request){
        $request->validate([
            'moduleID' => 'required|integer|exists:modules,moduleID'
        ]);
        
        try {
            DB::statement('EXEC DeleteModule ?', [
                $request->input('moduleID'),
            ]);
            return redirect()->back()->with('success', 'Module deleted successfully.');

        } catch (ValidationException $e) {
            // Return unsuccessful error if validation fails
            return redirect()->back()->with('failure', 'Invalid Procedure');
        }
    }
}
