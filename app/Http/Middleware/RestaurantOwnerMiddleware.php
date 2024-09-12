<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantOwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
         // Check if the user is authenticated and has the 'restaurant_owner' role
         if (Auth::check() && Auth::user()->role === 'restaurant_owner') {
            return $next($request);
        }

        // Optionally, you can return an error response or redirect to a specific page
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
