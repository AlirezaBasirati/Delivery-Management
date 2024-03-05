<?php

namespace App\Services\AuthorizationService\Middlewares;

use App\Services\AuthenticationService\Models\User;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;


class CheckRoutePermission
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws AuthorizationException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $user = auth()->user();
        if(!$user) {
            return $next($request);
        }

        /** @var User $user */
        $permissions = $user->cachePermissions();

        foreach ($permissions as $permission) {
            if (is_null($permission['route'])) continue;

            if ($permission['route']['name'] == $request->route()->getName()) {
                return $next($request);
            }
        }

        throw new AuthorizationException();
    }
}
