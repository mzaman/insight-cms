<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class SwitchGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if the request is API or web and set the default guard accordingly
        /*if ($request->is('api/*')) {
            Auth::setDefaultDriver('api');
        } else {
            Auth::setDefaultDriver('web');
        }*/
        // Check if the request is from API
        if (!$request->is('api/*')) {
            // Ensure the Web guard is used for web requests
            Auth::shouldUse('web');
        } else {
            // Ensure the API guard is being used for API requests
            Auth::shouldUse('api');
        }

        return $next($request);
    }
}