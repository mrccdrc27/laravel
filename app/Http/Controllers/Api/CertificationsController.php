<?php

namespace App\Http\Controllers\Api;

use App\Models\Certification;
use App\Http\Requests\StoreCertificationRequest;
use App\Http\Requests\UpdateCertificationRequest;
use App\Models\WebCertificate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class CertificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Example: GET http://127.0.0.1:8000/api/cert?courseID=7
        try {
            // Optional filtering parameters
            $courseID = $request->query('courseID');
            $userID = $request->query('userID');
            $issuedAt = $request->query('issuedAt') ? Carbon::parse($request->query('issuedAt')) : null;
            $expiryDate = $request->query('expiryDate') ? Carbon::parse($request->query('expiryDate')) : null;

            // Parameters for the stored procedure
            $params = [
                $courseID ?? null,
                $userID ?? null,
                $issuedAt,
                $expiryDate
            ];

            // Execute the stored procedure
            $certifications = DB::connection('sqlsrv')
                ->select('EXEC sp_certification_get_list ?, ?, ?, ?', $params);

            // Collect IDs for cross-database queries
            $userIds = collect($certifications)->pluck('userID')->unique();
            $courseIds = collect($certifications)->pluck('courseID')->unique();

            // Fetch additional details from the LMS database
            $users = DB::connection('sqlsrv_lms')
                ->table('users_info')
                ->join('users', 'users_info.userInfoID', '=', 'users.id')
                ->whereIn('users.id', $userIds)
                ->where('users.role', 'student')
                ->select(
                    'users.id AS userID',
                    'users.email',
                    'users_info.firstName',
                    'users_info.middleName',
                    'users_info.lastName'
                )
                ->get()
                ->keyBy('userID');

            $courses = DB::connection('sqlsrv_lms')
                ->table('courses')
                ->whereIn('courseID', $courseIds)
                ->select('courseID', 'title AS courseTitle')
                ->get()
                ->keyBy('courseID');

            // Additional details
            $certifications = collect($certifications)->map(function ($cert) use ($users, $courses) {
                $cert->user = $users->get($cert->userID);
                $cert->course = $courses->get($cert->courseID);
                return $cert;
            });

            // Return JSON response
            return response()->json([
                'success' => true,
                'data' => $certifications,
                'total' => count($certifications)
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching certifications: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching certifications.',
                'error' => $e->getMessage()
            ], 500);
        }
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
                    try {
                        $courseExists = DB::connection('sqlsrv_lms')
                            ->select('SELECT 1 FROM courses WHERE courseID = ?', [$value]);

                        if (empty($courseExists)) {
                            $fail("The selected course does not exist.");
                        }
                    } catch (\Exception $e) {
                        $fail("Error validating course: " . $e->getMessage());
                    }
                }
            ],
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'issuedAt' => 'required|date',
            'expiryDate' => 'nullable|date|after:issuedAt',
            'issuerID' => 'nullable|exists:issuer_information,issuerID',
            'userID' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if ($value !== null) {
                        try {
                            // Check if user exists and is a student in the LMS system
                            $userExists = DB::connection('sqlsrv_lms')
                                ->select('SELECT 1 FROM users WHERE id = ? AND role = ?', [$value, 'student']);

                            if (empty($userExists)) {
                                $fail("The selected user is not a valid student.");
                            }
                        } catch (\Exception $e) {
                            $fail("Error validating user: " . $e->getMessage());
                        }
                    }
                }
            ],
        ]);

        try {
            DB::beginTransaction();

            try {
                // Declare the output parameter
                $certificationId = 0;

                // Use DB::select to capture the result
                $result = DB::connection('sqlsrv')->select('
        DECLARE @certificationID BIGINT;
        EXEC sp_certification_insert 
            @certificationNumber = :certNumber, 
            @courseID = :courseID, 
            @title = :title, 
            @description = :description, 
            @issuedAt = :issuedAt, 
            @expiryDate = :expiryDate, 
            @issuerID = :issuerID, 
            @userID = :userID, 
            @certificationID = @certificationID OUTPUT;
        SELECT @certificationID AS certificationID;
    ', [
                    'certNumber' => $validatedData['certificationNumber'],
                    'courseID' => $validatedData['courseID'],
                    'title' => $validatedData['title'],
                    'description' => $validatedData['description'],
                    'issuedAt' => $validatedData['issuedAt'],
                    'expiryDate' => $validatedData['expiryDate'] ?? null,
                    'issuerID' => $validatedData['issuerID'] ?? null,
                    'userID' => $validatedData['userID'] ?? null
                ]);

                // Generates link to view the certificate
                $certificationId = $result[0]->certificationID;

                DB::commit();

                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'certificationID' => $certificationId,
                        'certificationNumber' => $validatedData['certificationNumber'],
                        'viewCertificateLink' => route('cert.details', ['id' => $certificationId])
                    ], 201);
                }

                return redirect()
                    ->route('cert.details', ['id' => $certificationId])
                    ->with('success', 'Certificate created successfully.');
            } catch (\Exception $e) {
                DB::rollBack();

                // Log the full error for debugging
                Log::error('Certification creation error: ' . $e->getMessage());
                Log::error('Error details: ' . json_encode([
                    'trace' => $e->getTraceAsString(),
                    'data' => $validatedData
                ]));

                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage(),
                    'details' => $e->getTraceAsString()
                ], 500);
            }
            /* Example response:
            {
                "success": true,
                "certificationID": 123,
                "certificationNumber": "CERT-2025-001",
                "viewCertificateLink": "http://your-domain.com/cert/details/123"
            }
            */
        } catch (\Exception $e) {
            DB::rollBack();

            // Log the full error for debugging
            Log::error('Certification creation error: ' . $e->getMessage());
            Log::error('Error details: ' . json_encode([
                'trace' => $e->getTraceAsString(),
                'data' => $validatedData
            ]));

            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'details' => $e->getTraceAsString()
            ], 500);
        }
    }
    /**
     * Display the specified certification
     */
    public function show(Request $request, $id)
    {
        try {
            $certificate = DB::select('EXEC sp_certification_get ?', [$id]);

            if (empty($certificate)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Certification not found.',
                ], 404);
            }

            // Generate certificate link
            $certificateLink = url("/cert/details/{$id}");

            return response()->json([
                'success' => true,
                'data' => $certificate[0],
                'certificateLink' => $certificateLink,
            ]);
        } catch (\Exception $e) {
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
            // Fetch certificate data using the stored procedure
            $certificate = DB::connection('sqlsrv')
                ->select('EXEC sp_certification_get_by_id ?', [$id]);

            if (empty($certificate)) {
                Log::warning("No certificate found with ID: $id");
                return view('errors.error', ['certificateId' => $id]);
            }

            $certificateData = (object) $certificate[0];

            // Fetch user information from LMS system
            $userInfo = null;
            if ($certificateData->userID) {
                $userInfo = DB::connection('sqlsrv_lms')
                    ->select('
                SELECT 
                    ui.userInfoID,
                    ui.firstName,
                    ui.middleName,
                    ui.lastName,
                    ui.birthDate,
                    ui.sex,
                    ui.nationality,
                    ui.birthPlace,
                    u.email,
                    u.id as studentID
                FROM users_info ui
                JOIN users u ON ui.userID = u.id
                WHERE u.id = ? AND u.role = ?
            ', [$certificateData->userID, 'student']);
            }

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
                $userInfo ? (array) $userInfo[0] : []
            );

            // Transform issuer details with direct binary to base64 conversion
            $certificateData->issuer = (object) [
                'firstName' => $certificateData->issuerFirstName ?? '',
                'lastName' => $certificateData->issuerLastName ?? '',
                'issuerSignature_base64' => !empty($certificateData->issuerSignatureBase64)
                    ? base64_encode($certificateData->issuerSignatureBase64)
                    : null,
                'organization' => (object) [
                    'name' => $certificateData->organizationName ?? '',
                    'logo_base64' => !empty($certificateData->organizationLogoBase64)
                        ? base64_encode($certificateData->organizationLogoBase64)
                        : null,
                ],
            ];

            // Add debug logging
            Log::debug('Binary data info', [
                'has_signature' => !empty($certificateData->issuerSignatureBase64),
                'has_logo' => !empty($certificateData->organizationLogoBase64),
                'signature_length' => !empty($certificateData->issuerSignatureBase64) ? strlen($certificateData->issuerSignatureBase64) : 0,
                'logo_length' => !empty($certificateData->organizationLogoBase64) ? strlen($certificateData->organizationLogoBase64) : 0,
            ]);

            // Fetch course information
            $course = DB::connection('sqlsrv_lms')
                ->select('SELECT title, description FROM Courses WHERE courseID = ?', [$certificateData->courseID]);

            // Add course information to the certificate data
            $certificateData->courseName = $course[0]->title ?? null;
            $certificateData->courseDescription = $course[0]->description ?? null;

            return view('certview', compact('certificateData'));
        } catch (\Exception $e) {
            Log::error('Certification fetch error: ' . $e->getMessage(), [
                'certificationID' => $id,
                'trace' => $e->getTraceAsString(),
            ]);
            return view('errors.generic_error', [
                'message' => 'An unexpected error occurred. Please try again later.',
            ]);
        }
    }

    public function showname(Request $request)
    {
        $firstName = $request->query('firstName');
        $middleName = $request->query('middleName');
        $lastName = $request->query('lastName');

        if (!$firstName && !$middleName && !$lastName) {
            return response()->json(['error' => 'At least one name parameter is required'], 400);
        }


        try {


            // Query users_info in the LMS database
            $usersQuery = DB::connection('sqlsrv_lms')
                ->table('users_info')
                ->join('users', 'users_info.userID', '=', 'users.id')
                ->where('users.role', 'student');



            if ($firstName) {
                $usersQuery->where('users_info.firstName', 'LIKE', "%{$firstName}%");
            }
            if ($middleName) {
                $usersQuery->where('users_info.middleName', 'LIKE', "%{$middleName}%");
            }
            if ($lastName) {
                $usersQuery->where('users_info.lastName', 'LIKE', "%{$lastName}%");
            }

            // Get the user IDs that match the name criteria
            $userIds = $usersQuery->pluck('users.id');


            // If no student is found, return an error message
            if ($userIds->isEmpty()) {
                return response()->json([
                    'error' => 'No student found with the given name or the user is not a student'
                ], 404); // 404 Not Found
            }

            // Fetch certifications for the user IDs using the certifications database
            $certifications = DB::connection('sqlsrv')
                ->table('certifications')
                ->whereIn('userID', $userIds)
                ->get();

            // If no certifications found for the student, return an error message
            if ($certifications->isEmpty()) {
                return response()->json([
                    'error' => 'No certifications found for the student'
                ], 404); // 404 Not Found
            }

            // Return the certifications if found
            return response()->json($certifications);
        } catch (\Exception $e) {
            Log::error('Error in showname method: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while searching certifications'
            ], 500); // Internal Server Error
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'certificationNumber' => 'sometimes|string|max:100',
            'courseID' => [
                'sometimes',
                'integer',
                function ($attribute, $value, $fail) {
                    try {
                        $courseExists = DB::connection('sqlsrv_lms')
                            ->select('SELECT 1 FROM Courses WHERE courseID = ?', [$value]);

                        if (empty($courseExists)) {
                            $fail("The selected course does not exist.");
                        }
                    } catch (\Exception $e) {
                        $fail("Error validating course: " . $e->getMessage());
                    }
                }
            ],
            'title' => 'sometimes|string|max:100',
            'description' => 'sometimes|string',
            'issuedAt' => 'sometimes|date',
            'expiryDate' => 'sometimes|nullable|date',
            'issuerID' => 'sometimes|nullable|exists:issuer_information,issuerID',
            'userID' => [
                'sometimes',
                'nullable',
                function ($attribute, $value, $fail) {
                    if ($value !== null) {
                        try {
                            // Check if user exists and is a student in the LMS system
                            $userExists = DB::connection('sqlsrv_lms')
                                ->select('SELECT 1 FROM users WHERE id = ? AND role = ?', [$value, 'student']);

                            if (empty($userExists)) {
                                $fail("The selected user is not a valid student.");
                            }
                        } catch (\Exception $e) {
                            $fail("Error validating user: " . $e->getMessage());
                        }
                    }
                }
            ],
        ]);

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

    public function getCertificationCount()
    {
        try {
            // Call the procedure to get the total count of certifications (non-web)
            $result = DB::connection('sqlsrv')
                ->select('EXEC sp_certification_get_count');
            $totalCertifications = $result[0]->TotalCertifications ?? 0;

            // Call the procedure to get the signed certifications count
            $signedResult = DB::connection('sqlsrv')
                ->select('EXEC sp_certification_get_signed_count');
            $signedCertifications = $signedResult[0]->TotalSignedCertificates ?? 0;

            // Get the web certifications count
            $webCertificationsCount = DB::table('web_certifications')->count();

            return response()->json([
                'success' => true,
                'count' => $totalCertifications, // Only non-web certifications
                'signedCount' => $signedCertifications,
                'webCertificationsCount' => $webCertificationsCount
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching certification count: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'count' => 0,
                'signedCount' => 0,
                'webCertificationsCount' => 0,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function verifyCertificate(Request $request, $certificationNumber)
    {
        try {
            // Fetch certification from CS-System
            $certificate = DB::select('EXEC sp_certification_get_by_code ?', [$certificationNumber]);

            if (empty($certificate)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or nonexistent certification number.',
                ], 404);
            }

            $certificate = $certificate[0];

            // Fetch user and course data from LMS-System
            $userInfo = DB::connection('sqlsrv_lms')
                ->table('users_info')
                ->where('userID', $certificate->userID)
                ->first();

            $certificate->user = $userInfo;

            $courseInfo = DB::connection('sqlsrv_lms')->table('courses')
                ->where('courseID', $certificate->courseID)
                ->select('title', 'description')
                ->first();

            // Compile response
            return response()->json([
                'success' => true,
                'data' => [
                    'certificate' => $certificate,
                    'user' => $userInfo,
                    'course' => $courseInfo,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while verifying the certificate.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return view('search_certificates', ['certificates' => collect()]);
        }

        try {
            // Use the stored procedure for searching regular certificates
            $certificates = collect(DB::select('EXEC sp_certification_search ?', [$query]));

            // Add web certificates search if needed
            if (Schema::hasTable('web_certifications')) {
                $webCertificates = WebCertificate::with(['issuer'])
                    ->where(function ($q) use ($query) {
                        $q->where('certificationNumber', 'LIKE', "%{$query}%")
                            ->orWhere('title', 'LIKE', "%{$query}%")
                            ->orWhere('name', 'LIKE', "%{$query}%")
                            ->orWhere('courseName', 'LIKE', "%{$query}%");
                    })
                    ->get()
                    ->map(function ($cert) {
                        $cert->type = 'web';
                        return $cert;
                    });

                $certificates = $certificates->concat($webCertificates);
            }

            return view('search_certificates', compact('certificates', 'query'));
        } catch (\Exception $e) {
            Log::error('Certificate search error: ' . $e->getMessage());
            return view('search_certificates', [
                'certificates' => collect(),
                'query' => $query,
                'error' => 'An error occurred while searching for certificates.'
            ]);
        }
    }
}
