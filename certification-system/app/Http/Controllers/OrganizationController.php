<?php

namespace App\Http\Controllers;

use App\Models\organization;
use App\Http\Requests\StoreorganizationRequest;
use App\Http\Requests\UpdateorganizationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all organizations from the database
        $organizations = organization::all();

        // Initialize an array to hold the formatted data
        $data = [];

        // Iterate over the organizations to encode the logos to Base64
        foreach ($organizations as $organization) {
            $logoData = $organization->logo; // Binary logo data
            
            // Convert the binary data to a base64 string
            $base64Logo = base64_encode($logoData);

            // Add the organization's data along with the Base64 logo
            $data[] = [
                'organizationID' => $organization->organizationID,
                'name' => $organization->name,
                'logo' => $base64Logo,  // Base64-encoded logo
                'created_at' => $organization->created_at,
                'updated_at' => $organization->updated_at,
            ];
        }

        // Return the organizations data as JSON
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
            'OrganizationName' => 'required|string|max:50',
            'Logo' => 'required|file|mimes:png,jpg,jpeg|max:5120',
        ]);

        // Convert Logo to binary
        $logo = file_get_contents($request->file('Logo')->getRealPath());
        $logoData = unpack("H*hex", $logo); // Unpack to hexadecimal string
        $logoData = '0x' . $logoData['hex']; // Prefix with '0x' to indicate binary data

        // Create the new organization record
        $organization = Organization::create([
            'name' => $request->OrganizationName,
            'logo' => DB::raw("CONVERT(VARBINARY(MAX), {$logoData})"), // Store logo as binary in database
        ]);

        // Return response with success message and the created organization
        return response()->json(['success' => true, 'data' => $organization], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(organization $organization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateorganizationRequest $request, organization $organization)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(organization $organization)
    {
        //
    }
}
