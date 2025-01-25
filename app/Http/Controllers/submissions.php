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
}
