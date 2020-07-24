<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    //Get the path the user should be redirected to when they are not authenticated to that page
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('ReturnToUnauthorizedPage');
        }
    }

}
