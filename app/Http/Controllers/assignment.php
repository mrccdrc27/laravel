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

}
