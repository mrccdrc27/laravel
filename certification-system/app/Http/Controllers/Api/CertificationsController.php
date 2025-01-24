<?php

namespace App\Http\Controllers\Api;

use App\Models\Certification;
use App\Http\Requests\StoreCertificationRequest;
use App\Http\Requests\UpdateCertificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class CertificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Placeholder 
        return response()->json(['message' => 'Not implemented']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'certificationNumber' => 'required|string|max:100|unique:certifications',
            'courseID' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    $courseExists = DB::connection('sqlsrv_lms')
                        ->table('courses')
                        ->where('courseID', $value)
                        ->exists();

                    if (!$courseExists) {
                        $fail("The selected course does not exist.");
                    }
                }
            ],
            // 'courseID' => 'required|integer|exists:courseID,course',
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'issuedAt' => 'required|date',
            'expiryDate' => 'nullable|date',
            'issuerID' => 'nullable',
            // 'issuerID' => 'nullable|exists:issuer_information,issuerID',
            'userID' => 'nullable',
            // 'userID' => 'nullable|exists:user_info,userID',
        ]);

        try {
            $certificationId = 0;
            DB::statement('EXEC sp_certification_insert 
                @certificationNumber = ?, 
                @courseID = ?, 
                @title = ?, 
                @description = ?, 
                @issuedAt = ?, 
                @expiryDate = ?, 
                @issuerID = ?, 
                @userID = ?, 
                @certificationID = ? OUTPUT',
                [
                    $validatedData['certificationNumber'],
                    $validatedData['courseID'],
                    $validatedData['title'],
                    $validatedData['description'],
                    $validatedData['issuedAt'],
                    $validatedData['expiryDate'] ?? null,
                    $validatedData['issuerID'] ?? null,
                    $validatedData['userID'] ?? null,
                    &
                    $certificationId
                ]
            );

            return response()->json([
                'success' => true,
                'certificationNumber' => $validatedData['certificationNumber']
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified certification
     */
    public function show(Request $request, $id)
    {
        try {

            $certificate = DB::select('EXEC sp_certification_get_by_id ?', [$id]);

            if (empty($certificate)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Certification not found.',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $certificate[0],
            ]);
        } catch (\Exception $e) {
            // Handle any unexpected exceptions
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching the certification.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getByID($id)
    {
        try {
            // Fetch certificate data
            $certificate = DB::connection('sqlsrv')
                ->select('EXEC sp_certification_get_by_id ?', [$id]);

            if (empty($certificate)) {
                Log::warning("No certificate found with ID: $id");
                return abort(404);
            }

            $certificateData = (object) $certificate[0];

            // Transform user info
            $certificateData->userInfo = (object) array_merge(
                [
                    'firstName' => '',
                    'middleName' => '',
                    'lastName' => '',
                    'studentID' => '',
                    'email' => '',
                    'nationality' => '',
                    'birthDate' => '',
                    'sex' => null,
                    'birthPlace' => ''
                ],
                (array) $certificateData
            );

            // Transform issuer info
            $certificateData->issuer = (object) [
                'firstName' => $certificateData->issuerFirstName ?? '',
                'lastName' => $certificateData->issuerLastName ?? '',
                'issuerSignature' => property_exists($certificateData, 'issuerSignature')
                    ? $certificateData->issuerSignature
                    : null,
                'issuerSignature_base64' => (property_exists($certificateData, 'issuerSignature')
                    && $certificateData->issuerSignature
                    && $certificateData->issuerSignature !== '0x')
                    ? base64_encode($certificateData->issuerSignature)
                    : null,
                // Add the organization information
                'organization' => (object) [
                    'name' => $certificateData->organizationName ?? '',
                    'logo_base64' => ($certificateData->organizationLogo && $certificateData->organizationLogo !== '0x')
                        ? base64_encode($certificateData->organizationLogo)
                        : null,
                ]
            ];

            // Fetch course information using raw SQL
            $course = DB::connection('sqlsrv_lms')
                ->select('SELECT title, description FROM courses WHERE courseID = ?', [$certificateData->courseID]);

            // Add course information to the certificate data
            if ($course) {
                $certificateData->courseName = $course[0]->title;
                $certificateData->courseDescription = $course[0]->description;
            } else {
                // Handle case where course is not found, if necessary
                $certificateData->courseName = null;
                $certificateData->courseDescription = null;
            }

            // // Fetch course information
            // $course = DB::connection('sqlsrv_lms')
            //     ->table('courses')
            //     ->where('courseID', $certificateData->courseID)
            //     ->first();


            // // Add course information to the certificate data
            // $certificateData->courseName = optional($course)->title;
            // $certificateData->courseDescription = optional($course)->description;

            return view('certview', compact('certificateData'));
        } catch (\Exception $e) {
            Log::error('Certification fetch error: ' . $e->getMessage());
            Log::error('Details: ' . json_encode([
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]));
            return abort(500);
        }
    }

    public function showname(Request $request)
    {
        $name = $request->query('name');

        if (!$name) {
            return response()->json(['error' => 'Name parameter is required'], 400);
        }

        try {
            $certifications = DB::select('EXEC sp_certification_get_by_name ?', [$name]);
            return response()->json($certifications);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'certificationNumber' => 'sometimes|string|max:100',
            'courseID' => 'sometimes|integer',
            'title' => 'sometimes|string|max:100',
            'description' => 'sometimes|string',
            'issuedAt' => 'sometimes|date',
            'expiryDate' => 'sometimes|nullable|date',
            'issuerID' => 'sometimes|nullable|integer',
            'userID' => 'sometimes|nullable|integer',
        ]);
        // 'userID' => 'nullable|exists:user_info,userID',
        // 'issuerID' => 'nullable|exists:issuer_information,issuerID',
        // 'courseID' => 'required|integer|exists:courseID,course',
        DB::statement('EXEC sp_certification_update ?, ?, ?, ?, ?, ?, ?, ?, ?', [
            $id,
            $validated['certificationNumber'] ?? null,
            $validated['courseID'] ?? null,
            $validated['title'] ?? null,
            $validated['description'] ?? null,
            $validated['issuedAt'] ?? null,
            $validated['expiryDate'] ?? null,
            $validated['issuerID'] ?? null,
            $validated['userID'] ?? null,
        ]);

        return response()->json(['message' => 'Certification updated successfully.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $result = DB::select('EXEC sp_certification_delete ?', [$id]);

            // Check status from stored procedure
            if ($result[0]->Status == 0) {
                throw new \Exception('Certification not found.');
            }

            return response()->json(['message' => 'Certification deleted successfully.'], 200);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the execution
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
