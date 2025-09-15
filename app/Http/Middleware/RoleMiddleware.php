<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }

        if (!in_array(Auth::user()->role_type, $roles)) {
            Auth::logout(); // Logout the user if they don't have permission
            return redirect()->route('login')->with('error', 'Unauthorized access. Please log in with the correct account.');
        }

        return $next($request);
    }
}

