<?php

namespace App\Http\Middleware;

use Closure;

class CheckIsDeactivate
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
        $user = auth()->user();

        if($user->is_deactive == true)
        {
            auth()->logout();
            return redirect()->route('login')->withMessage('Your account has been deactivated.');
        }

        return $next($request);
    }
}
