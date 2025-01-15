<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::with('userInfo')->get();
            return response()->json([
                'success' => true,
                'data' => $users
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
        DB::beginTransaction();
        try {
            // Validate user data
            $validated = $request->validate([
                'Username' => 'required|unique:users,Username|max:50',
                'Password' => 'required|min:8',
                'Role' => 'required|in:' . implode(',', UserInfo::VALID_ROLES),
                'FirstName' => 'required|string|max:50',
                'LastName' => 'required|string|max:50',
                'MiddleName' => 'nullable|string|max:50',
                'Email' => 'required|email|unique:users_info,Email',
                'BirthDate' => 'required|date',
                'Sex' => 'required|boolean',
                'Nationality' => 'required|string|max:50',
                'BirthPlace' => 'required|string|max:100'
            ]);

            // Create user
            $user = User::create([
                'Username' => $validated['Username'],
                'PasswordHash' => Hash::make($validated['Password']),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Create user info
            $userInfo = new UserInfo([
                'Role' => $validated['Role'],
                'FirstName' => $validated['FirstName'],
                'LastName' => $validated['LastName'],
                'MiddleName' => $validated['MiddleName'],
                'Email' => $validated['Email'],
                'BirthDate' => $validated['BirthDate'],
                'Sex' => $validated['Sex'],
                'Nationality' => $validated['Nationality'],
                'BirthPlace' => $validated['BirthPlace'],
                'IsActive' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $user->userInfo()->save($userInfo); // Eloquent sets the UserID foreign key in the users_info table based on the primary key of the $user

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'data' => $user->load('userInfo')
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
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
            $user = User::with('userInfo')->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);

            // Validate input
            $validated = $request->validate([
                'Username' => 'sometimes|required|unique:users,Username,' . $id . ',UserID|max:50',
                'Password' => 'sometimes|required|min:8',
                'Role' => 'sometimes|required|in:' . implode(',', UserInfo::VALID_ROLES),
                'FirstName' => 'sometimes|required|string|max:50',
                'LastName' => 'sometimes|required|string|max:50',
                'MiddleName' => 'nullable|string|max:50',
                'Email' => 'sometimes|required|email|unique:users_info,Email,' . optional($user->userInfo()->first())->UserInfoID . ',UserInfoID',
                'BirthDate' => 'sometimes|required|date',
                'Sex' => 'sometimes|required|boolean',
                'Nationality' => 'sometimes|required|string|max:50',
                'BirthPlace' => 'sometimes|required|string|max:100',
                'IsActive' => 'sometimes|required|boolean',
            ]);

            // Update user attributes
            if (isset($validated['Username'])) {
                $user->Username = $validated['Username'];
            }
            if (isset($validated['Password'])) {
                $user->PasswordHash = Hash::make($validated['Password']);
            }
            $user->updated_at = now();  // Add this line
            $user->save();

            // Update user info if present
            $userInfo = $user->userInfo()->first();
            if ($userInfo) {
                $userInfoData = array_intersect_key($validated, array_flip([
                    'Role',
                    'FirstName',
                    'LastName',
                    'MiddleName',
                    'Email',
                    'BirthDate',
                    'Sex',
                    'Nationality',
                    'BirthPlace',
                    'IsActive'
                ]));
                if (!empty($userInfoData)) {
                    $userInfoData['updated_at'] = now();  // Add this line
                    $userInfo->update($userInfoData);
                }
            }
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'data' => $user->load('userInfo')
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);

            // Soft delete or handle related records if needed
            $user->userInfo()->delete();
            $user->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
