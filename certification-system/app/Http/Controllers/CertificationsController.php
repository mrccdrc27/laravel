<?php

namespace App\Http\Controllers;

use App\Models\certifications;
use App\Http\Requests\StorecertificationsRequest;
use App\Http\Requests\UpdatecertificationsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CertificationsController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->get('search');
            $perPage = $request->get('per_page', 15);
            $page = $request->get('page', 1);
            $offset = ($page - 1) * $perPage;

            $query = "
                EXEC sp_GetCertifications 
                    @SearchTerm = ?,
                    @PageSize = ?,
                    @Offset = ?
            ";

            $results = DB::select($query, [$search, $perPage, $offset]);

            return response()->json([
                'success' => true,
                'data' => $results,
                'meta' => [
                    'current_page' => $page,
                    'per_page' => $perPage
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
    
    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'certificationNumber' => 'required|unique:certifications|max:100',
                'courseID' => 'required|integer',
                'title' => 'required|string|max:100',
                'description' => 'required|string',
                'issuedAt' => 'required|date',
                'expiryDate' => 'nullable|date|after:issuedAt',
                'issuerID' => 'nullable|exists:issuer_information,issuerID',
                'userID' => 'nullable|exists:user_info,userID'
            ]);

            /**
             * Execute the stored procedure 'sp_StoreCertification' to create a new certification record.
             * 
             * 
             * @param array $validated The validated request data
             * @return array Returns newly created certification record with user details
             * 
             */
            $result = DB::select(
                'EXEC sp_StoreCertification ?, ?, ?, ?, ?, ?, ?, ?',
                [
                    $validated['certificationNumber'],
                    $validated['courseID'],
                    $validated['title'],
                    $validated['description'],
                    $validated['issuedAt'],
                    $validated['expiryDate'],
                    $validated['issuerID'],
                    $validated['userID']
                ]
            );

            /**
             * @todo Add QR code logic if needed
             */

            return response()->json([
                'success' => true,
                'message' => 'Certification created successfully',
                'data' => $result[0]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create certification',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the certification by its ID. Return 404 if not found
        $certificate = certifications::where('certificationID', $id)
            ->with(['userinfo', 'issuer', 'issuer.organization'])  // Eager load all relationships
            ->first();

        // Check if certification exists
        if (!$certificate) {
            // Return a 404 error if not found
            abort(code: 404);
        }

        // Return the view and pass the certification object to the view
        return view('certview', compact('certificate'));
    }

    public function showname(Request $request)
    {
        // Retrieve the name from query parameters
        $name = $request->query('name');

        // Check if the name is provided
        if (!$name) {
            return response()->json(['error' => 'Name parameter is required'], 400);
        }

        // Search for certifications where userinfo has matching name fields
        $certifications = certifications::whereHas('userinfo', function ($query) use ($name) {
            $query->where('firstName', 'like', "$name%")
                ->orWhere('middleName', 'like', "$name%")
                ->orWhere('lastName', 'like', "$name%");
        })
            ->with(['userinfo:userID,firstName,middleName,lastName']) // Eager load relationships
            ->get();

        // Return the results as JSON
        return response()->json($certifications);
    }

    /**
     * Update the specified certification.
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'certificationNumber' => 'sometimes|required|unique:certifications,certificationNumber,' . $id . ',certificationID|max:100',
                'courseID' => 'sometimes|required|integer',
                'title' => 'sometimes|required|string|max:100',
                'description' => 'sometimes|required|string',
                'issuedAt' => 'sometimes|required|date',
                'expiryDate' => 'nullable|date|after:issuedAt',
                'issuerID' => 'nullable|exists:issuer_information,issuerID',
                'userID' => 'nullable|exists:user_info,userID'
            ]);

            DB::beginTransaction();

            $result = DB::select(
                'EXEC sp_UpdateCertification ?, ?, ?, ?, ?, ?, ?, ?, ?',
                [
                    $id,
                    $validated['certificationNumber'] ?? null,
                    $validated['courseID'] ?? null,
                    $validated['title'] ?? null,
                    $validated['description'] ?? null,
                    $validated['issuedAt'] ?? null,
                    $validated['expiryDate'] ?? null,
                    $validated['issuerID'] ?? null,
                    $validated['userID'] ?? null
                ]
            );

            /**
             * @todo Add QR code logic if needed
             */

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Certification updated successfully',
                'data' => $result[0]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update certification',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Remove the specified certification.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            // Get certification details before deletion
            $certification = DB::select('
                SELECT certificationID, qrCodePath 
                FROM certifications 
                WHERE certificationID = ?',
                [$id]
            );

            if (empty($certification)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Certification not found'
                ], 404);
            }

            // Execute delete stored procedure
            DB::select('EXEC sp_DeleteCertification ?', [$id]);

            /**
             * @todo Add QR certification logic if needed
             */

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Certification deleted successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete certification',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
