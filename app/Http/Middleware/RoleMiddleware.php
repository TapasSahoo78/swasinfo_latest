<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $permission = null)
    {

        $userRoles = $request->user()->roles->pluck('slug')->toArray();
        dd($role);
        $role= explode('|',$role);
        if(empty(array_intersect($role, $userRoles))) {
            abort(401);
        }
        if($permission !== null && !auth()->user()->can($permission)) {
            abort(401);
        }

        return $next($request);
    }
}
