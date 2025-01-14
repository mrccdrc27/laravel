<?php

namespace App\Http\Controllers;

use App\Models\certifications;
use App\Http\Requests\StorecertificationsRequest;
use App\Http\Requests\UpdatecertificationsRequest;
use Illuminate\Http\Request;


class CertificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return certifications::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
                // Validate the incoming request
                $request->validate([
                    'certificationNumber' => 'required|string|max:100|unique:certifications',
                    'courseID' => 'required|integer',
                    'title' => 'required|string|max:100',
                    'description' => 'required|string',
                    'issuedAt' => 'required|date',
                    'expiryDate' => 'nullable|date',
                    'issuerID' => 'nullable|exists:issuer_information,issuerID',
                    'userID' => 'nullable|exists:user_info,userID',
                ]);
        
                // Create the new certification record
                $certification = certifications::create([
                    'certificationNumber' => $request->certificationNumber,
                    'courseID' => $request->courseID,
                    'title' => $request->title,
                    'description' => $request->description,
                    'issuedAt' => $request->issuedAt,
                    'expiryDate' => $request->expiryDate,
                    'issuerID' => $request->issuerID,
                    'userID' => $request->userID,
                ]);
        
                // Return response with success message and the created certification
                return response()->json(['success' => true, 'data' => $certification], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(certifications $certifications)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecertificationsRequest $request, certifications $certifications)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(certifications $certifications)
    {
        //
    }
}
