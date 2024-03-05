<?php

namespace App\Services\AuthorizationService\Middlewares;

use App\Services\AuthenticationService\Models\User;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;


class CheckUserBlock
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws AuthorizationException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        /** @var User $user */
        $user = auth()->user();

        if(!$user) {
            return $next($request);
        }

        if (!$user->is_blocked) {
            return $next($request);
        }

        throw new AuthorizationException();
    }
}
