<?php

namespace App\Services\AuthorizationService\Middlewares;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param $permission
     * @return Response|RedirectResponse
     * @throws AuthorizationException
     */
    public function handle(Request $request, Closure $next, $permission): Response|RedirectResponse
    {
        if (Gate::allows('permission', $permission)) {
            return $next($request);
        }

        throw new AuthorizationException();
    }
}
