<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Request;

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
        // route to login page 
        if (!$request->expectsJson()) {

            // if request has admin in start route to the admin login page
            if (Request::is('admin*'))
                return route('get.admin.login');

            else
                // if request no has admin at the start route user login page
                return route('login');

        }
    }
}