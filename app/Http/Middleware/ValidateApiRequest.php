<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateApiRequest
{
    public function handle(Request $request, Closure $next)
    {
        // Retrieve API key and platform token from headers
        $apiKey = $request->header('API_KEY');
        $platformToken = $request->header('X-Platform-Key');


        // Check if the API key and platform token are provided
        if (!$platformToken) {
            return response()->json([
                'message' => 'API key and platform token are required.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Validate the API key (example: checking against a stored value or environment variable)
        // if ($apiKey !== env('API_KEY')) {
        //     return response()->json([
        //         'message' => 'Invalid API key.'
        //     ], Response::HTTP_UNAUTHORIZED);
        // }

        // Validate the platform token (example: checking against a stored value or database)
        if ($platformToken !== env('PLATFORM_TOKEN')) {
            return response()->json([
                'message' => 'Invalid platform token.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        // If both are valid, continue the request
        return $next($request);
    }
}
