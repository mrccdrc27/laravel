<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\Updateuser_infoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        Log::info($request->all());

        $validatedData = $request->validate([
            'studentID' => 'required|integer',
            'firstName' => 'required|string|max:50',
            'middleName' => 'nullable|string|max:50',
            'lastName' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'birthDate' => 'required|date',
            'sex' => 'required|boolean',
            'nationality' => 'required|string|max:50',
            'birthPlace' => 'required|string|max:100',
        ]);
        // Try to create a new user information record
        try {
            $user = User::create([
                'studentID' => $validatedData['studentID'],
                'firstName' => $validatedData['firstName'],
                'middleName' => $validatedData['middleName'] ?? null,
                'lastName' => $validatedData['lastName'],
                'email' => $validatedData['email'],
                'birthDate' => $validatedData['birthDate'],
                'sex' => $validatedData['sex'],
                'nationality' => $validatedData['nationality'],
                'birthPlace' => $validatedData['birthPlace'],
            ]);

            // Return a success response
            return response()->json([
                'message' => 'User information stored successfully.',
                'data' => $user,
            ], 201);

        } catch (\Exception $e) {
            // Catch any exceptions that occur during the creation
            return response()->json([
                'error' => 'Failed to store user information.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user_info)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Updateuser_infoRequest $request, User  $user_info)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user_info)
    {
        //
    }
}
