<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    // public function handle(Request $request, Closure $next)
    // {
    //     dd(Auth::user()->role_type);
    //     if (!Auth::check() || !Auth::user()->role_type) {
    //         dd("test");
    //         // If the user is not logged in or not an admin, redirect to the home page or login page
    //         return redirect('/');
    //     }

    //     return $next($request);
    // }

    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect('/login');  // Direct to login page if not authenticated
        }

        // Ensure the user has a role type and it is set to 'admin'
        if (!Auth::user()->role_type || Auth::user()->role_type != "admin") {
            return redirect('/');  // Redirect to home if not the correct role
        }
        // dd(Auth::user()->role_type);
        // If user is an admin, redirect to admin dashboard
        if (Auth::user()->role_type == "admin") {
            // return redirect()->route('admin.dashboard');
            // if ($request->route()->named('admin.dashboard')) {
            //     return $next($request);
            // }
            if (!$request->route()->named('admin.dashboard')) {

                return redirect()->route('admin.dashboard');
            }
           
            // return redirect()->route('admin.dashboard');
        }

        // Proceed with the request to next middleware or controller
        return $next($request);
    }
}
