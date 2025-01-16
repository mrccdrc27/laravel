<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class facultyMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::user() && Auth::user()->role === 'faculty') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Access denied.');
    }
}
