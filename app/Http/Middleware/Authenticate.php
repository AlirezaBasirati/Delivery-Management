<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Laravel\Passport\Exceptions\AuthenticationException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     * @throws AuthenticationException
     */
    protected function redirectTo(Request $request)
    {
        return $request->expectsJson() ? null : throw new AuthenticationException();
    }
}
