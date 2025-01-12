<?php

namespace App\Http\Controllers;

use App\Models\issuer_information;
use App\Http\Requests\Storeissuer_informationRequest;
use App\Http\Requests\Updateissuer_informationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IssuerInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return issuer_information::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Validate the incoming request
         $request->validate([
            'firstName' => 'required|string|max:50',
            'middleName' => 'nullable|string|max:50',
            'lastName' => 'required|string|max:50',
            'issuerSignature' => 'required|file|mimes:png,jpg,jpeg|max:5120',
            'organizationID' => 'required|exists:organization,organizationID', // Ensure organization exists
        ]);

        // Convert issuerSignature to binary
        $issuerSignature = file_get_contents($request->file('issuerSignature')->getRealPath());
        $signatureData = unpack("H*hex", $issuerSignature); // Unpack to hexadecimal string
        $signatureData = '0x' . $signatureData['hex']; // Prefix with '0x' to indicate binary data

        // Create the new issuer information record
        $issuerInformation = issuer_information::create([
            'firstName' => $request->firstName,
            'middleName' => $request->middleName,
            'lastName' => $request->lastName,
            'issuerSignature' => DB::raw("CONVERT(VARBINARY(MAX), {$signatureData})"), // Store issuerSignature as binary
            'organizationID' => $request->organizationID,
        ]);

        // Return response with success message and the created issuer information
        return response()->json(['success' => true, 'data' => $issuerInformation], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(issuer_information $issuer_information)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updateissuer_informationRequest $request, issuer_information $issuer_information)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(issuer_information $issuer_information)
    {
        //
    }
}
