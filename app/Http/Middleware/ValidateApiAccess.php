<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use App\Models\ApiKey; // Ensure you have this model


class ValidateApiAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next)
    // {
    //     // Step 1: Get Public IP of this server
    //    // dd( $request);
    //     try {
    //         $response = Http::timeout(5)->get('https://api64.ipify.org?format=json');
    //         if ($response->failed()) {
    //             return response()->json(['message' => 'Unable to fetch public IP'], 500);
    //         }
    //         $serverIp = $response->json('ip');
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'Error fetching IP: ' . $e->getMessage()], 500);
    //     }

    //     // Step 2: Get API key and user ID from request headers
    //     $apiKey = $request->header('X-API-TOKEN');
    //     $userId = $request->header('USER-ID');

    //     if (!$apiKey || !$userId) {
    //         return response()->json(['message' => 'API Key and User ID are required'], 401);
    //     }

    //     // Step 3: Validate against DB
    //     $record = ApiKey::where('api_key', $apiKey)
    //         ->where('user_id', $userId)
    //         ->where('ip_address', $serverIp)
    //         ->where('active', true)
    //         ->first();

    //     if (!$record) {
    //         return response()->json([
    //             'message' => 'Unauthorized access',
    //             'ip_address' => 'Your IP Address is not Whitleisted with erfp portal'
    //         ], 401);
    //     }

    //     return $next($request);
    // }

    // public function handle(Request $request, Closure $next)
    // {
    //     // Step 1: Get server's public IP (or use a local method if needed)
    //     try {

    //       //  $serverIp = $request->getClientIp();
    //       $clientIp = $request->header('X-Forwarded-For') ?? $request->ip();
    //        // dd( $clientIp);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'Error fetching IP: ' . $e->getMessage()], 500);
    //     }

    //     // Step 2: Get API key only from header
    //     $apiKey = $request->header('X-API-TOKEN');

    //     if (!$apiKey) {
    //         return response()->json(['message' => 'API Token is required'], 401);
    //     }

    //     // Step 3: Validate against DB using only the API key
    //     $record = ApiKey::where('api_key', $apiKey)
    //         ->where('ip_address', $serverIp)
    //         ->where('active', true)
    //         ->first();

    //     if (!$record) {
    //         return response()->json([
    //             'message' => 'Unauthorized access',
    //             'ip_address' => 'Your IP Address is not whitelisted or token is invalid.'
    //         ], 401);
    //     }

    //     // Optionally bind the user to the request for downstream use
    //     $request->merge(['user_id' => $record->user_id]);

    //     return $next($request);
    // }

    //added at 29-4-2025


    // public function handle(Request $request, Closure $next): Response
    // {
    //     try {
    //         // Step 1: Get client IP address (handle proxy cases)
    //         $clientIp = $request->header('X-Forwarded-For') ?? $request->ip();
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error fetching IP: ' . $e->getMessage()
    //         ], 500);
    //     }

    //     // Step 2: Get API key from header
    //     $apiKey = $request->header('X-API-TOKEN');

    //     if (!$apiKey) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'API Token is required'
    //         ], 401);
    //     }

    //     // Step 3: Validate against database (token + IP)
    //     $record = ApiKey::where('api_key', $apiKey)
    //         ->where('ip_address', $clientIp)
    //         ->where('active', true)
    //         ->first();

    //     if (!$record) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Unauthorized access. IP not whitelisted or token invalid.',
    //             'client_ip' => $clientIp
    //         ], 401);
    //     }

    //     // Step 4: Optionally attach user ID to request
    //     $request->merge(['user_id' => $record->user_id]);

    //     return $next($request);
    // }



    /*
    public function handle(Request $request, Closure $next): Response
    {


         try {
            // Step 1: Get client IP address (handle proxy cases)
            $clientIp = $request->header('X-Forwarded-For') ?? $request->ip();
            //dd($clientIp);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching IP: ' . $e->getMessage()
            ], 500);
        }
       
        // Step 2: Get API key from header
        $apiKey = $request->header('X-API-TOKEN');


        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'API Token is required'
            ], 401);
        }


        // Step 3: Validate against database (token + IP)
        $record = ApiKey::where('api_key', $apiKey)
            ->where('ip_address', $clientIp)
            ->where('active', true)
            ->first();
        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access. IP not whitelisted or token invalid.',
                'client_ip' => $clientIp
            ], 401);
        }

        // Step 4: Optionally attach user ID to request
        // by jdr
        $this->logRequest($request, $clientIp, 'Authorized', $record->user_id);

        $request->merge(['user_id' => $record->user_id]);

        return $next($request);
    }*/

    /**
     * Log request details
     */
    /*protected function logRequest(Request $request, string $ip, string $status, $userId = null)
    {
        Log::channel('api_access')->info('API Access Log', [
            'time'       => now()->toDateTimeString(),
            'ip'         => $ip,
            'user_agent' => $request->userAgent(),
            'method'     => $request->method(),
            'url'        => $request->fullUrl(),
            'api_token'  => $request->header('X-API-TOKEN'),
            'status'     => $status,
            'user_id'    => $userId,
        ]);
    }
    */
    // new code by jalaj on 01-09-2025

    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Step 1: Get client IP (prefer X-Forwarded-For if present)
            $forwardedFor = $request->header('X-Forwarded-For');
            if ($forwardedFor) {
                $ips = array_map('trim', explode(',', $forwardedFor));
                $clientIp = $ips[0]; // first IP = real client
            } else {
                $clientIp = $request->ip();
            }
        } catch (\Exception $e) {
            $this->logRequest($request, 'IP_FETCH_ERROR', null, $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching IP: ' . $e->getMessage()
            ], 500);
        }

        // Step 2: Get API token
        $apiKey = $request->header('X-API-TOKEN');
        if (!$apiKey) {
            $this->logRequest($request, 'MISSING_API_TOKEN', $clientIp);
            return response()->json([
                'success' => false,
                'message' => 'API Token is required'
            ], 401);
        }

        // Step 3: Look up token
        $record = ApiKey::where('api_key', $apiKey)->first();

        if (!$record) {
            $this->logRequest($request, 'INVALID_API_TOKEN', $clientIp);
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: Invalid API token.',
                'client_ip' => $clientIp
            ], 401);
        }

        // Step 4: Check active flag
        if (!$record->active) {
            $this->logRequest($request, 'INACTIVE_API_TOKEN', $clientIp, $record->user_id);
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: API token is inactive.',
                'client_ip' => $clientIp
            ], 401);
        }

        // Step 5: Check IP match
        if ($record->ip_address !== $clientIp) {
            $this->logRequest($request, 'IP_NOT_WHITELISTED', $clientIp, $record->user_id);
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: IP not whitelisted for this token.',
                'client_ip' => $clientIp
            ], 401);
        }

        // Step 6: Authorized
        $this->logRequest($request, 'AUTHORIZED', $clientIp, $record->user_id);
        $request->merge(['user_id' => $record->user_id]);

        return $next($request);
    }

    /**
     * 
     * Write detailed log entry
     */
    protected function logRequest(Request $request, string $status, ?string $ip = null, $userId = null)
    {
        Log::channel('api_access')->info('API Access Log', [
            'time'       => now()->toDateTimeString(),
            'status'     => $status,
            'ip'         => $ip,
            'method'     => $request->method(),
            'url'        => $request->fullUrl(),
            'api_token'  => $request->header('X-API-TOKEN'),
            'user_id'    => $userId,
            'user_agent' => $request->userAgent(),
        ]);
    }
}
