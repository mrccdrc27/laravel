<?php

namespace App\Http\Controllers;

use App\Models\organization;
use App\Http\Requests\StoreorganizationRequest;
use App\Http\Requests\UpdateorganizationRequest;
use Illuminate\Http\Request;

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
    public function store(StoreorganizationRequest $request)
    {
        
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:50',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle the uploaded logo image
        $logoPath = $request->file('logo')->store('logos', 'public');

        // Create the new organization
        $organization = Organization::create([
            'name' => $request->input('name'),
            'logo' => $logoPath, // Store the logo's file path
        ]);

        return response()->json($organization, 201);
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
