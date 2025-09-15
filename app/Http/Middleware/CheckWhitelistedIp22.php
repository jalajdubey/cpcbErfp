<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ApiKey;
class CheckWhitelistedIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $whitelistedIps = [
            '127.0.0.2',
            '192.168.1.100',
            '203.0.113.42',
        ];

        $clientIp = $request->ip();

        if (!in_array($clientIp, $whitelistedIps)) {
            return response()->json([
                'message' => 'Access denied. IP not allowed.',
                'client_ip' => $clientIp
            ], 403);
        }

        return $next($request);
    }
}

