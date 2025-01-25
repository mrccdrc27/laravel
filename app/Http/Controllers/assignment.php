<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon; // Import Carbon
class assignment extends Controller
{
    public function store(Request $request)
{
    try {
        // Validate incoming request
        $request->validate([
            'courseID' => 'required|integer|exists:courses,courseID',
            'title' => 'required|string|max:100',
            'instructions' => 'required',
            'file' => 'nullable|file|max:10240', // Optional file, adjust size if needed
            'duedate' => 'nullable|date|after:today', // Validate that the due date is a date after today
        ]);

        // Initialize filePath variable
        $filePath = null;

        // Check if the file exists and store it
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('assignments', 'public');
        }

        // Convert duedate to desired format (YYYY-MM-DD HH:MM:SS) if present
        $duedate = $request->input('duedate');
        if ($duedate) {
            $duedate = Carbon::parse($duedate)->format('Y-m-d H:i:s');
        }

        // Call the stored procedure
        DB::statement('EXEC createAssignment ?, ?, ?, ?, ?', [
            $request->input('courseID'),
            $request->input('title'),
            $filePath,
            $request->input('instructions'),
            $duedate, // Pass the formatted due date
        ]);

        // Return success message
        return redirect()->back()->with('success', 'Module created successfully.');

    } catch (ValidationException $e) {
        // Handle validation exception
        return redirect()->back()->withErrors($e->validator)->withInput();
    } catch (\Exception $e) {
        // Handle other exceptions (e.g., DB or general errors)
        return redirect()->back()->with('success', 'Module not created, there was an error. Please try again.');
    }
}

public function update(Request $request)
{
    try {
        // Validate incoming request
        $request->validate([
            'assignmentID' => 'required|integer|exists:assignments,assignmentID',
            'title' => 'required|string|max:100',
            'instructions' => 'required',
            'oldfile' => 'nullable|file|max:10240', // Optional file, adjust size if needed
            'duedate' => 'nullable|date|after:today', // Validate that the due date is a date after today
        ]);

        // Initialize filePath variable
        $filePath = null;

        // // Check if the file exists and store it
        // if ($request->hasFile('file')) {
        //     $file = $request->file('file');
        //     $filePath = $file->store('assignments', 'public');
        // }

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
            $filePath = $file->store('assignments', 'public');
        }

        // Convert duedate to desired format (YYYY-MM-DD HH:MM:SS) if present
        $duedate = $request->input('duedate');
        if ($duedate) {
            $duedate = Carbon::parse($duedate)->format('Y-m-d H:i:s');
        }

        // Call the stored procedure
        DB::statement('EXEC updateAssignment ?, ?, ?, ?, ?', [
            $request->input('assignmentID'),
            $request->input('title'),
            $filePath,
            $request->input('instructions'),
            $duedate, // Pass the formatted due date
        ]);

        // Return success message
        return redirect()->back()->with('success', 'Module updated successfully.');

    } catch (ValidationException $e) {
        // Handle validation exception
        return redirect()->back()->withErrors($e->validator)->withInput();
    } catch (\Exception $e) {
        // Handle other exceptions (e.g., DB or general errors)
        return redirect()->back()->with('success', 'Module not updated, there was an error. Please try again.');
    }
}
public function delete(Request $request){
    // $request->validate([
    //     'assignmentID' => 'required|integer|exists:assignments,assignmentID'
    // ]);
    
    try {
        DB::statement('EXEC DeleteAssignment ?', [
            $request->input('assignmentID'),
        ]);
        return redirect()->back()->with('success', 'Assignment deleted successfully.');

    } catch (ValidationException $e) {
        // Return unsuccessful error if validation fails
        return redirect()->back()->with('success', 'Invalid Procedure');
    }
}
}
