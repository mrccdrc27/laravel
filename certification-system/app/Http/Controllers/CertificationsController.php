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
        //return certifications::all();
        //return view('dashboard.search');
        //return redirect()->route('');
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
    public function show($id)
    {
        // Find the certification by its ID or return 404 if not found
        $certificate = certifications::where('certificationID', $id)
        ->with(['userinfo', 'issuer','issuer.organization'])  // Eager load all relationships
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
