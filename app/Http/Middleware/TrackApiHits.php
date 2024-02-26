<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\ApiHit;
use Carbon\Carbon;

class TrackApiHits
{
    public function handle($request, Closure $next)
    {
        $userId = auth()->id();
        $requestPage = $request->page;
        
        // Check if a record exists for the current day with the same user ID and request page
        $existingHit = ApiHit::where('user_id', $userId)
            ->where('request_page', $requestPage)
            ->whereDate('created_at', Carbon::today())
            ->first();
    
        // If no record exists, create a new entry
        if (!$existingHit &&  $request->path() !== "api/v1/customers/screen_time") {
            ApiHit::create([
                'user_id' => $userId,
                'route' => $request->path(),
                'method' => $request->method(),
                'ip_address' => $request->ip(),
                'request_page' => $requestPage,
                'created_at' => now(),
            ]);
        }
    
        return $next($request);
    }
}
