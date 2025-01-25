<?php

namespace App\Http\Controllers\Api;

use App\Models\Certification;
use App\Http\Requests\StoreCertificationRequest;
use App\Http\Requests\UpdateCertificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class CertificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    // Example: GET /certifications?courseID=101&issuedAt=2024-01-01&expiryDate=2025-01-01
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

            $certificationId = 0; // This variable will hold the generated certificationID after the stored procedure executes
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
                    &$certificationId // Pass by reference
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'certificationID' => $certificationId,
                'certificationNumber' => $validatedData['certificationNumber']
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

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

            // Fetch user information from LMS system's users_info table
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

            // Transform issuer 
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
                ->select('SELECT title, description FROM Courses WHERE courseID = ?', [$certificateData->courseID]);

            // Add course information to the certificate data
            if ($course) {
                $certificateData->courseName = $course[0]->title;
                $certificateData->courseDescription = $course[0]->description;
            } else {
                // Handle case where course is not found, if necessary
                $certificateData->courseName = null;
                $certificateData->courseDescription = null;
            }

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


            if ($userIds->isEmpty()) {
                return response()->json([]);
            }

            // Fetch certifications for the user IDs using the certifications database
            $certifications = DB::connection('sqlsrv')
                ->table('certifications')
                ->whereIn('userID', $userIds)
                ->get();

            return response()->json($certifications);
        } catch (\Exception $e) {
            Log::error('Error in showname method: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while searching certifications'], 500);
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
}
