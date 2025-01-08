<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Assessment;
use DB;
use Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Str;
class AssessmentController
{
    /**
     * Display a listing of the resource.
     * Example API calls:
     * GET /assessments                     // Get all assessments
     * GET /assessments?CourseID=123       // Filter by course
     * GET /assessments?per_page=20        // 20 items per page
     * GET /assessments?page=2             // Get second page
     */
    public function index(Request $request)
    {
        $query = Assessment::with(['course', 'faculty', 'submissions']);

        if ($request->has('CourseID')) // Checks if 'CourseID' exists in the request parameters
        {
            $query->where('CourseID', $request->CourseID); // 1st parameter: Column name, 2nd: Operator or Value
        }

        $assessments = $query->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'data' => $assessments->items(),
            'meta' => [
                'total' => $assessments->total(),
                'current_page' => $assessments->currentPage(),
                'last_page' => $assessments->lastPage(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'CourseID' => 'required|exists:courses,CourseID',
                'FacultyID' => 'required|exists:users,UserID',
                'Title' => 'required|string|max:100',
                'Type' => 'required|string|in:Multiple Choice,Identification|max:50',
                'FileName' => 'required|file|mimes:pdf,doc,docx|max:5120', 
                'DueDate' => 'nullable|date|after:today'
            ]);

            DB::beginTransaction();
            try {
                // File upload
                if ($request->hasFile('FileName')) {
                    $filename = Str::slug($validated['Title']) . '_' . time() . '.' .
                        $request->file('FileName')->extension();

                    Storage::disk('public')->putFileAs(
                        'assessments',
                        $request->file('FileName'),
                        $filename
                    );

                    $validated['FileData'] = 'assessments/' . $filename;
                    $validated['FileType'] = $request->file('FileName')->getClientMimeType();
                    $validated['FileName'] = $filename;
                }

                $assessment = Assessment::create($validated);
                DB::commit();

                return response()->json(['success' => true, 'data' => $assessment], 201);
            } catch (\Exception $e) {
                DB::rollBack();
                // Clean up uploaded file
                if (isset($validated['FileData'])) {
                    Storage::disk('public')->delete($validated['FileData']);
                }
                throw $e;
            }

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create assessment',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $assessment = Assessment::with(['course', 'faculty', 'submissions'])->findOrFail($id);
            return response()->json(['success' => true, 'data' => $assessment]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Assessment not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $assessment = Assessment::findOrFail($id);

            $validated = $request->validate([
                'CourseID' => 'required|exists:courses,CourseID',
                'FacultyID' => 'required|exists:users,UserID',
                'Title' => 'required|string|max:100',
                'Type' => 'required|string|in:Multiple Choice,Identification|max:50',
                'FileName' => 'sometimes|required|file|mimes:pdf,doc,docx|max:5120',
                'DueDate' => 'nullable|date|after:today'
            ]);

            $oldFile = $assessment->FileData;
            $newFilePath = null;

            try {
                // Handle file upload
                if ($request->hasFile('FileName')) {
                    $filename = Str::slug($validated['Title']) . '_' . time() . '.' .
                        $request->file('FileName')->extension();

                    Storage::disk('public')->putFileAs(
                        'assessments',
                        $request->file('FileName'),
                        $filename
                    );

                    $newFilePath = 'assessments/' . $filename;
                    $validated['FileData'] = $newFilePath;
                    $validated['FileType'] = $request->file('FileName')->getClientMimeType();
                    $validated['FileName'] = $filename;
                }

                $assessment->update($validated);

                // Delete old file if new one was uploaded
                if ($newFilePath && $oldFile) {
                    Storage::disk('public')->delete($oldFile);
                }

                DB::commit();
                return response()->json(['success' => true, 'data' => $assessment]);

            } catch (\Exception $e) {
                // Clean up new file if there was an error
                if ($newFilePath) {
                    Storage::disk('public')->delete($newFilePath);
                }
                throw $e;
            }

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Assessment not found'], 404);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update assessment',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $assessment = Assessment::findOrFail($id);

            // Check if file exists then delete
            if ($assessment->FileName && Storage::disk('public')->exists($assessment->FileName)) {
                Storage::disk('public')->delete($assessment->FileName);
            }

            // Delete the assessment record
            $assessment->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Assessment deleted successfully',
            ], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Assessment not found',
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete assessment',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
