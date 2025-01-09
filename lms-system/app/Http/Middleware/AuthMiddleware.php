<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\User;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'No authorization token provided'
            ], 401);
        }

        // Get user ID from cache using token
        $userId = Cache::get('auth_token_' . $token);

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired token'
            ], 401);
        }

        // Get user and attach to request
        $user = User::with('userInfo')->where('UserID', $userId)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        auth()->setUser($user);

        return $next($request);
    }
}