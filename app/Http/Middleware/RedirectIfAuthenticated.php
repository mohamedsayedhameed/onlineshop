<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        /* if (Auth::guard($guard)->check()) {
           // return redirect(RouteServiceProvider::HOME);
            if($guard=='web')
                 return redirect(RouteServiceProvider::HOME);
        } */

        /* redirect after authenticate */
        if (Auth::guard($guard)->check()) {

            // if guard was admin redirect to the dashboard
            if($guard=='admin')
                return redirect(RouteServiceProvider::ADMIN);

            else
                // redirect to home page if guard not admin
                return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
