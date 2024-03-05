<?php

namespace App\Services\AuthorizationService\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Services\AuthorizationService\Repository\V1\Admin\Authorization\AuthorizationInterface as AuthorizationService;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;

class AuthorizationController extends Controller
{
    private AuthorizationService $authorizationService;

    public function __construct(AuthorizationService $authorizationService)
    {
        $this->authorizationService = $authorizationService;
    }

    public function access(): JsonResponse
    {
        $permissions = $this->authorizationService->access();

        return Responser::collection($permissions);
    }

}
