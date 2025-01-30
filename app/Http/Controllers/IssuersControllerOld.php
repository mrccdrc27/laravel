<?php

namespace App\Http\Controllers;

use App\Models\Issuer;
use App\Http\Requests\Storeissuer_informationRequest;
use App\Http\Requests\Updateissuer_informationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IssuersControllerOld extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        // Fetch all issuer information from the database
        $issuers = Issuer::all();

        // Initialize an array to hold the formatted data
        $data = [];

        // Iterate over the issuers to encode the signature to Base64
        foreach ($issuers as $issuer) {
            $signatureData = $issuer->issuerSignature; // Binary signature data
            
            // Convert the binary signature data to a base64 string
            $base64Signature = base64_encode($signatureData);

            // Add the issuer's data along with the Base64 signature
            $data[] = [
                'issuerID' => $issuer->issuerID,
                'firstName' => $issuer->firstName,
                'middleName' => $issuer->middleName,
                'lastName' => $issuer->lastName,
                'issuerSignature' => $base64Signature,  // Base64-encoded signature
                'organizationID' => $issuer->organizationID,
                'created_at' => $issuer->created_at,
                'updated_at' => $issuer->updated_at,
            ];
        }

        // Return the issuer information data as JSON
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
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
        $issuerInformation = Issuer::create([
            'firstName' => $request->firstName,
            'middleName' => $request->middleName,
            'lastName' => $request->lastName,
            'issuerSignature' => DB::raw("CONVERT(VARBINARY(MAX), {$signatureData})"), // Store issuerSignature as binary
            'organizationID' => $request->organizationID,
        ]);

        $return = ([
            'firstName' => $request->firstName,
            'middleName' => $request->middleName,
            'lastName' => $request->lastName,
            'organizationID' => $request->organizationID,
        ]);

        // Return response with success message and the created issuer information
        return response()->json(['success' => true, 'data' => $return], 201);
    }

    /**
     * Display the specified resource.
     */
    // public function show(Issuer $issuer_information)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Updateissuer_informationRequest $request, Issuer $issuer_information)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Issuer $issuer_information)
    // {
    //     //
    // }
}
