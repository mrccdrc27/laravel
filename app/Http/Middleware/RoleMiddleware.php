<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        if (!Auth::check()) {
            // Redirect to login if not authenticated
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if the user is a 'root', and bypass all further checks
        if ($user->role === 'root') {
            return $next($request);
        }


        $user = Auth::user();

        // Check if user has the required role(s)
        $roles = is_array($roles) ? $roles : explode('|', $roles);
        if (!in_array($user->role, $roles)) {
            // Redirect or abort if unauthorized
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
