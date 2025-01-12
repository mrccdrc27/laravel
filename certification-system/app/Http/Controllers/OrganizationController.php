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
        //
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
