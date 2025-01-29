<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebCertificateController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'courseName' => 'required|string|max:100',
            'courseDescription' => 'required|string',
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'issuedAt' => 'required|date',
            'expiryDate' => 'nullable|date|after:issuedAt',
            'name' => 'nullable|string|max:255', // Update to nullable
        ]);

        try {
            DB::beginTransaction();

            // Format the dates properly for SQL Server
            $issuedAt = date('Y-m-d H:i:s', strtotime($validated['issuedAt']));
            $expiryDate = !empty($validated['expiryDate']) ? date('Y-m-d', strtotime($validated['expiryDate'])) : null;

            // Execute the stored procedure using statement
            $certificationId = DB::selectOne('
            SET NOCOUNT ON;
            DECLARE @certificationID BIGINT;
            EXEC sp_web_certification_insert 
                @courseName = ?,
                @courseDescription = ?,
                @title = ?,
                @description = ?,
                @issuedAt = ?,
                @expiryDate = ?,
                @issuerID = ?,
                @name = ?,
                @certificationID = @certificationID OUTPUT;
            SELECT @certificationID as certificationID;
        ', [
                $validated['courseName'],
                $validated['courseDescription'],
                $validated['title'],
                $validated['description'],
                $issuedAt,
                $expiryDate,
                null,
                $validated['name'] ?? null, // Allow null if name is not provided
            ])->certificationID;

            DB::commit();

            return redirect()
                ->route('web.certificates.show', ['id' => $certificationId])
                ->with('success', 'Certificate created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Web certification creation error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data' => $validated
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'An error occurred while creating the certificate.']);
        }
    }

    public function show($id)
    {
        try {
            // Fetch certificate data using the stored procedure
            $certificate = DB::connection('sqlsrv')
                ->select('EXEC sp_web_certification_get_by_id ?', [$id]);

            if (empty($certificate)) {
                Log::warning("No web certificate found with ID: $id");
                return view('errors.error', ['certificateId' => $id]);
            }

            // Structure the data to match the existing view format
            $certificateData = (object) [
                'certificationID' => $certificate[0]->certificationID,
                'certificationNumber' => $certificate[0]->certificationNumber,
                'courseName' => $certificate[0]->courseName,
                'courseDescription' => $certificate[0]->courseDescription,
                'title' => $certificate[0]->title,
                'description' => $certificate[0]->description,
                'issuedAt' => $certificate[0]->issuedAt,
                'expiryDate' => $certificate[0]->expiryDate,
                'userInfo' => (object) [
                    'firstName' => $certificate[0]->name ?? '', // Handle null name gracefully
                    'middleName' => '',
                    'lastName' => '',
                    'email' => ''
                ],
                'issuer' => (object) [
                    'firstName' => $certificate[0]->issuerFirstName ?? '',
                    'lastName' => $certificate[0]->issuerLastName ?? '',
                    'issuerSignature_base64' => !empty($certificate[0]->issuerSignatureBase64)
                        ? base64_encode($certificate[0]->issuerSignatureBase64)
                        : null,
                    'organization' => (object) [
                        'name' => $certificate[0]->organizationName ?? '',
                        'logo_base64' => !empty($certificate[0]->organizationLogoBase64)
                            ? base64_encode($certificate[0]->organizationLogoBase64)
                            : null,
                    ],
                ]
            ];

            return view('certview', compact('certificateData'));
        } catch (\Exception $e) {
            Log::error('Web certification fetch error: ' . $e->getMessage(), [
                'certificationID' => $id,
                'trace' => $e->getTraceAsString(),
            ]);
            return view('errors.generic_error', [
                'message' => 'An unexpected error occurred. Please try again later.',
            ]);
        }
    }

    public function getWebCertificationCount()
    {
        try {
            // Get the count of web certifications
            $webCertificationsCount = DB::table('web_certifications')->count();
    
            return response()->json([
                'success' => true,
                'webCertificationsCount' => (int)$webCertificationsCount, // Cast to integer
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
