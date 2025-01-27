<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
class issuer extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          /**
     * Insert a new issuer into the database
     */

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:50',
            'middleName' => 'nullable|string|max:50',
            'lastName' => 'required|string|max:50',
            'issuerSignature' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'organizationID' => 'required|integer|exists:organization,organizationID',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Handle file upload
        try {
            // Store the issuer signature file
            $file = $request->file('issuerSignature');
            $filePath = $file->storeAs('issuer_signatures', uniqid() . '.' . $file->getClientOriginalExtension(), 'public');

            // Run the stored procedure to insert issuer data
            DB::statement("EXEC InsertIssuerInformation 
                ?, 
                ?, 
                ?, 
                ?, 
                ?", 
                [
                    $request->firstName,
                    $request->middleName ?? null,
                    $request->lastName,
                    $filePath,
                    $request->organizationID
                ]
            );



            // Return a success response
            return response()->json([
                'message' => 'Issuer information has been successfully added.',
                'data' => [
                    'firstName' => $request->firstName,
                    'middleName' => $request->middleName,
                    'lastName' => $request->lastName,
                    'organizationID' => $request->organizationID,
                    'issuerSignaturePath' => $filePath,
                ]
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            // If there is an error, return error response
            return response()->json([
                'error' => 'Something went wrong while inserting issuer information.',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Call the stored procedure
            $result = DB::select('EXEC DeleteIssuerInformation ?', [$id]);

            // Check if any row was affected
            $rowsAffected = $result[0]->RowsAffected ?? 0;

            if ($rowsAffected > 0) {
                return response()->json(['message' => 'Issuer deleted successfully.'], 200);
            } else {
                return response()->json(['message' => 'Issuer not found.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting issuer.', 'error' => $e->getMessage()], 500);
        }
    }
}
