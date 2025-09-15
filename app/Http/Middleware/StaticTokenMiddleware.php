<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaticTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
      //dd($token);
        $validTokens = [
            'AAABBHH$$$8285205104',
        ];

        if (!$token || !in_array($token, $validTokens)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access. Token invalid.'
            ], 401);
        }

        return $next($request);
    }
}
