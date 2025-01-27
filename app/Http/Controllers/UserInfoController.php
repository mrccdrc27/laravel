<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->get('search');
            $perPage = $request->get('per_page', 15);
            $page = $request->get('page', 1);
            $offset = ($page - 1) * $perPage;

            $results = DB::select(
                'EXEC sp_GetUsers @SearchTerm = ?, @PageSize = ?, @Offset = ?',
                [$search, $perPage, $offset]
            );

            return response()->json([
                'success' => true,
                'data' => $results,
                'meta' => [
                    'current_page' => $page,
                    'per_page' => $perPage
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving users',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
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

            $result = DB::select(
                'EXEC sp_StoreUser ?, ?, ?, ?, ?, ?, ?, ?, ?',
                [
                    $validated['studentID'],
                    $validated['firstName'],
                    $validated['middleName'],
                    $validated['lastName'],
                    $validated['email'],
                    $validated['birthDate'],
                    $validated['sex'],
                    $validated['nationality'],
                    $validated['birthPlace']
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'data' => $result[0]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $result = DB::select('EXEC sp_GetUserById ?', [$id]);

            if (empty($result)) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Group certifications with user data
            $user = $result[0];
            $certifications = array_map(function ($row) {
                return [
                    'certificationID' => $row->certificationID,
                    'certificationNumber' => $row->certificationNumber,
                    'title' => $row->certificationTitle
                ];
            }, array_filter($result, fn($row) => $row->certificationID !== null));

            $userData = (array) $user;
            unset($userData['certificationID'], $userData['certificationNumber'], $userData['certificationTitle']);
            $userData['certifications'] = $certifications;

            return response()->json([
                'success' => true,
                'data' => $userData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving user',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'studentID' => 'sometimes|required|integer',
                'firstName' => 'sometimes|required|string|max:50',
                'middleName' => 'nullable|string|max:50',
                'lastName' => 'sometimes|required|string|max:50',
                'email' => 'sometimes|required|email|max:100',
                'birthDate' => 'sometimes|required|date',
                'sex' => 'sometimes|required|boolean',
                'nationality' => 'sometimes|required|string|max:50',
                'birthPlace' => 'sometimes|required|string|max:100',
            ]);

            $result = DB::select(
                'EXEC sp_UpdateUser ?, ?, ?, ?, ?, ?, ?, ?, ?, ?',
                [
                    $id,
                    $validated['studentID'] ?? null,
                    $validated['firstName'] ?? null,
                    $validated['middleName'] ?? null,
                    $validated['lastName'] ?? null,
                    $validated['email'] ?? null,
                    $validated['birthDate'] ?? null,
                    $validated['sex'] ?? null,
                    $validated['nationality'] ?? null,
                    $validated['birthPlace'] ?? null
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'data' => $result[0]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::select('EXEC sp_DeleteUser ?', [$id]);

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
