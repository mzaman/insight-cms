<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        try {
            // If the request is an API request, return a JSON response with a 401 error
            if ($request->is('api/*')) {
                $ErrorResponse = [
                    'success' => false,
                    'error' => 'Unauthorized',
                    'message' => 'Invalid or expired Token, or unauthorized access',
                ];
                abort(response()->json($ErrorResponse, 403)); // Use 401 for unauthorized API requests
            }

            // For non-API requests, return the login route
            if (! $request->expectsJson()) {
                return route('login');
            }

        } catch (AuthenticationException $e) {
            // Handle AuthenticationException and return a 401 response for API requests
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized',
                'message' => 'Authentication failed. Please log in.'
            ], 401);
        }
    }
}
