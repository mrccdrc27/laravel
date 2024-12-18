<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificationController extends Controller
{

    #Retrieve certifications with filtering and pagination.
    #https://laravel.com/docs/5.0/eloquent -> Eloquent ORM 
    #https://laracasts.com/discuss/channels/requests/request-vs-request?page=1&replyId=379336
    public function index(Request $request)
    {
        try {
            $query = Certification::query();

            // Advanced filtering options
            # https://laravel.com/docs/11.x/queries#where-clauses
            if ($request->has('search')) { // Checks if search parameter exists in the request (example request:GET /certifications?search=text)
                # https://laravel.com/docs/11.x/queries#subquery-where-clauses
                $search = $request->search;
                $query->where(function ($q) use ($search) {  //function($q) anonymous function, use allows $search variable inside function
                    $q->where('FirstName', 'LIKE', "%{$search}%") //$q constructs sub query logic (syntax: $query->where('column', 'operator', 'value')
                        ->orWhere('LastName', 'LIKE', "%{$search}%") // Logical Grouping https://laravel.com/docs/master/queries#logical-grouping:~:text=%2D%3Eget()%3B-,Logical%20Grouping,-Sometimes%20you%20may
                        ->orWhere('CertificationNumber', 'LIKE', "%{$search}%")
                        ->orWhere('Email', 'LIKE', "%{$search}%");
                });
            }

            // Filter by specific fields
            if ($request->has('nationality')) {
                $query->where('Nationality', $request->nationality);
            }

            if ($request->has('course_id')) {
                $query->where('CourseID', $request->course_id);
            }

            // Date range filtering
            if ($request->has('start_date') && $request->has('end_date')) {
                $query->whereBetween('IssuedAt', [
                    $request->start_date,
                    $request->end_date
                ]);
            }

            // Pagination with relationships
            # https://laravel.com/docs/11.x/pagination
            $certifications = $query->with(['student', 'course', 'issuer'])
                ->paginate($request->get('per_page', 15)); //Example: GET /certifications?per_page=20

            return response()->json([
                'success' => true,
                'data' => $certifications->items(),
                'meta' => [
                    'total' => $certifications->total(),
                    'current_page' => $certifications->currentPage(),
                    'last_page' => $certifications->lastPage()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving certifications',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    # Retrieve specific certification
    public function show($id)
    {
        $certification = Certification::with(['student', 'course', 'issuer'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $certification
        ]);
    }

    # Create new certification
    public function store(Request $request)
    {
        try {
            // Validation constraints for incoming data
            # https://laravel.com/docs/11.x/validation 
            $validated = $request->validate([
                'CertificationNumber' => 'required|unique:certifications|max:100',
                'StudentID' => 'required|exists:students,StudentID',
                'FirstName' => 'required|string|max:50',
                'MiddleName' => 'nullable|string|max:50',
                'LastName' => 'required|string|max:50',
                'Email' => 'required|email|max:100',
                'BirthDate' => 'required|date',
                'Sex' => 'required|boolean',
                'Nationality' => 'required|string|max:50',
                'BirthPlace' => 'required|string|max:100',
                'CourseID' => 'required|exists:courses,CourseID',
                'Title' => 'required|string|max:100',
                'Description' => 'required|string',
                'IssuedAt' => 'required|date',
                'ExpiryDate' => 'nullable|date|after:IssuedAt',
                'CertificationPath' => 'required|file|mimes:pdf,jpg,png|max:2048',
                'IssuerID' => 'nullable|exists:issuer_information,IssuerID'
            ]);

            // Handle file upload
            if ($request->hasFile('CertificationPath')) {
                $path = $request->file('CertificationPath')->store('certifications', 'public');
                $validated['CertificationPath'] = $path;
            }

            $certification = Certification::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Certification created successfully',
                'data' => $certification
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    # Update existing certification
    public function update(Request $request, $id)
    {
        try {
            $certification = Certification::findOrFail($id);

            $validated = $request->validate([
                'CertificationNumber' => 'sometimes|required|unique:certifications,CertificationNumber,' . $id . ',CertificationID|max:100',
                'StudentID' => 'sometimes|required|exists:students,StudentID',
                'FirstName' => 'sometimes|required|string|max:50',
                'MiddleName' => 'nullable|string|max:50',
                'LastName' => 'sometimes|required|string|max:50',
                'Email' => 'sometimes|required|email|max:100',
                'BirthDate' => 'sometimes|required|date',
                'Sex' => 'sometimes|required|boolean',
                'Nationality' => 'sometimes|required|string|max:50',
                'BirthPlace' => 'sometimes|required|string|max:100',
                'CourseID' => 'sometimes|required|exists:courses,CourseID',
                'Title' => 'sometimes|required|string|max:100',
                'Description' => 'sometimes|required|string',
                'IssuedAt' => 'sometimes|required|date',
                'ExpiryDate' => 'nullable|date|after:IssuedAt',
                'CertificationPath' => 'sometimes|file|mimes:pdf,jpg,png|max:2048',
                'IssuerID' => 'nullable|exists:issuer_information,IssuerID'
            ]);

            // Handle file upload if new file is provided
            if ($request->hasFile('CertificationPath')) {
                // Delete old file if exists
                if ($certification->CertificationPath) {
                    Storage::disk('public')->delete($certification->CertificationPath);
                }

                $path = $request->file('CertificationPath')->store('certifications', 'public');
                $validated['CertificationPath'] = $path;
            }

            $certification->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Certification updated successfully',
                'data' => $certification
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Update failed',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }


    # Soft delete a certification.

    public function destroy($id)
    {
        try {
            $certification = Certification::findOrFail($id);
            $certification->delete();

            return response()->json([
                'success' => true,
                'message' => 'Certification deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Deletion failed',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function GenerateQR($id)
    {
        $certification = Certification::findOrFail($id); // Retrieve certification details


        $qrData = route('certifications.show', ['id' => $certification->id]);
        $qrCode = QrCode::format('svg')->size(200)->generate($qrData);

        return response()->json(
            [
                'success' => true,
                'qr_code' => $qrCode,
            ]
        );
    }

}