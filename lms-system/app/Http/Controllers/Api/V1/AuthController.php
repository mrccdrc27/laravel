<?php

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    /**
     * Authenticate user and generate token
     */
    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'Username' => 'required|string',
                'Password' => 'required|string'
            ]);

            // Find user by username
            $user = User::with('userInfo')->where('Username', $validated['Username'])->first();

            if (!$user || !Hash::check($validated['Password'], $user->PasswordHash)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            // Check if user is active
            if (!$user->userInfo->first()->IsActive) {
                return response()->json([
                    'success' => false,
                    'message' => 'Account is inactive'
                ], 403);
            }

            // Generate token
            $token = Str::random(60);
            
            // Store token in cache with user ID, expires in 24 hours

            Cache::put('auth_token_' . $token, $user->UserID, 60 * 24);

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Change user password
     */
    public function changePassword(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();
            
            $validated = $request->validate([
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:8|different:current_password',
                'confirm_password' => 'required|string|same:new_password'
            ]);

            if (!Hash::check($validated['current_password'], $user->PasswordHash)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect'
                ], 401);
            }

            $user->PasswordHash = Hash::make($validated['new_password']);
            $user->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to change password',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            if ($token) {
                // Remove token from cache
                Cache::forget('auth_token_' . $token);
            }

            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Logout failed',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Get authenticated user information
     */
    public function me()
    {
        try {
            $user = auth()->user();
            return response()->json([
                'success' => true,
                'data' => $user->load('userInfo')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve user information',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}