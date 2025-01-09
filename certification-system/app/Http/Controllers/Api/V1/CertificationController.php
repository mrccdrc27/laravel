<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Rules\ExistsInLMS;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use RateLimiter;
class CertificationController extends Controller
{

    

    /**
     * Retrieve all certifications with optional filtering and pagination.
     *
     * @param Request $request The HTTP request object.
     * @return \Illuminate\Http\JsonResponse JSON response containing certifications data or error message.
     * @link https://laracasts.com/discuss/channels/requests/request-vs-request?page=1&replyId=379336
     * @link https://laravel.com/docs/5.0/eloquent -> Eloquent ORM 
     */

    public function index(Request $request)
    {
        try {
            $query = Certification::query();

            // Advanced filtering options
            # https://laravel.com/docs/11.x/queries#where-clauses
            if ($request->has('search')) { // Checks if search parameter exists in the request (example request:GET /certifications?search=text)
                # https://laravel.com/docs/11.x/queries#subquery-where-clauses
                $search = trim($request->search);
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



    /**
     * Create a new certification entry in the database.
     *
     * @param Request $request The HTTP request containing the certification data.
     * @return \Illuminate\Http\JsonResponse JSON response indicating success or validation errors.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validation constraints for incoming data
            # https://laravel.com/docs/11.x/validation 
            $validated = $request->validate([
                'CertificationNumber' => 'required|unique:certifications|max:100',
                // 'StudentID' => 'required|integer',
                // 'StudentID' => 'required|exists:users,UserID',
                'StudentID' => ['required', new ExistsInLMS('users', 'UserID')],
                'FirstName' => 'required|string|max:50',
                'MiddleName' => 'nullable|string|max:50',
                'LastName' => 'required|string|max:50',
                'Email' => 'required|email|max:100',
                'BirthDate' => 'required|date',
                'Sex' => 'required|boolean',
                'Nationality' => 'required|string|max:50',
                'BirthPlace' => 'required|string|max:100',
                // 'CourseID' => 'required|integer',
                'CourseID' => ['required', new ExistsInLMS('courses', 'CourseID')],
                'Title' => 'required|string|max:100',
                'Description' => 'required|string',
                'IssuedAt' => 'required|date',
                'ExpiryDate' => 'nullable|date|after:IssuedAt',
                'IssuerID' => 'nullable|exists:issuer_information,IssuerID'
                // 'IssuerID' => 'nullable|integer'
            ]);

            $certification = new Certification($validated);

            try {
                $certificationPath = $this->generateQRCode($certification);
                $validated['CertificationPath'] = $certificationPath;

                $certification = Certification::create($validated);
                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Certification created successfully',
                    'data' => $certification,
                    'qr_code_url' => asset('storage/' . $certificationPath)
                ], 201);
            } catch (\Exception $e) {
                if (isset($certificationPath)) {
                    Storage::disk('public')->delete($certificationPath);
                }
                throw $e;
            }
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
                'message' => 'Failed to create certification',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    # Retrieve specific certification
    public function show($id)
    {
        $certification = Certification::with(['issuer'])->findOrFail($id);



        return response()->json([
            'success' => true,
            'data' => $certification
        ]);
    }

    # Update existing certification
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $certification = Certification::findOrFail($id);

            $validated = $request->validate([
                'CertificationNumber' => 'sometimes|required|unique:certifications,CertificationNumber,' . $id . ',CertificationID|max:100',
                'StudentID' => 'sometimes|required|integer',
                'FirstName' => 'sometimes|required|string|max:50',
                'MiddleName' => 'nullable|string|max:50',
                'LastName' => 'sometimes|required|string|max:50',
                'Email' => 'sometimes|required|email|max:100',
                'BirthDate' => 'sometimes|required|date',
                'Sex' => 'sometimes|required|boolean',
                'Nationality' => 'sometimes|required|string|max:50',
                'BirthPlace' => 'sometimes|required|string|max:100',
                'CourseID' => 'sometimes|required|integer',
                'Title' => 'sometimes|required|string|max:100',
                'Description' => 'sometimes|required|string',
                'IssuedAt' => 'sometimes|required|date',
                'ExpiryDate' => 'nullable|date|after:IssuedAt',
                'IssuerID' => 'nullable|integer'
            ]);

            $oldPath = $certification->CertificationPath;

            try {
                if ($request->has('CertificationNumber') && $certification->CertificationNumber !== $validated['CertificationNumber']) {
                    $certificationPath = $this->generateQRCode($certification);
                    $validated['CertificationPath'] = $certificationPath;
                }

                $certification->update($validated);

                if (isset($certificationPath) && $oldPath) {
                    Storage::disk('public')->delete($oldPath);
                }

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Certification updated successfully',
                    'data' => $certification
                ]);
            } catch (\Exception $e) {
                if (isset($certificationPath)) {
                    Storage::disk('public')->delete($certificationPath);
                }
                throw $e;
            }
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
                'message' => 'Update failed',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    # Delete a certification.
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $certification = Certification::findOrFail($id);
            $filePath = str_replace(asset('storage') . '/', '', $certification->CertificationPath);

            $certification->delete();

            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Certification deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Deletion failed',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }


    protected function generateQRCode($certification)
    {
        $qrData = route('certifications.qr-code', ['id' => $certification->CertificationID]);
        $qrCode = QrCode::format('svg')->size(200)->generate($qrData);
        $qrCodePath = 'certifications/qr_codes/' . $certification->CertificationID . '_' . $certification->CertificationNumber . '.svg';
        Storage::disk('public')->put($qrCodePath, $qrCode);
        return $qrCodePath;
    }

    public function showQR($id)
    {
        try {
            $certification = Certification::with(['issuer', 'course', 'student'])->findOrFail($id);

            if (RateLimiter::tooManyAttempts('view-qr-' . request()->ip(), 60)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Too many attempts. Please try again later.'
                ], 429);
            }

            RateLimiter::hit('view-qr-' . request()->ip());


            return view('certifications.qr-code', ['certification' => $certification]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving QR code',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 404);
        }
    }




}