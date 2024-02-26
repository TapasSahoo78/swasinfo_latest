<?php

namespace App\Http\Middleware;

use Closure;

class CheckIsApprove
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

        if(!$user->is_approve)
        {
            return redirect()->route('login')->withMessage('Your account is not approve');
        }

        return $next($request);
    }
}
