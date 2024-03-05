<?php

namespace App\Services\AuthorizationService\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Services\AuthenticationService\Models\User;
use App\Services\AuthenticationService\Resources\V1\Common\User\UserResource;
use App\Services\AuthorizationService\Repository\V1\Admin\User\UserInterface;
use App\Services\AuthorizationService\Requests\V1\Admin\User\BlockOrUnblockRequest;
use App\Services\AuthorizationService\Requests\V1\Admin\User\SyncPermissionRequest;
use App\Services\AuthorizationService\Requests\V1\Admin\User\SyncRoleRequest;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(private readonly UserInterface $userRepository)
    {
    }

    public function syncPermissions(User $user, SyncPermissionRequest $request): JsonResponse
    {
        $user = $this->userRepository->syncPermissionsById($user, $request->get('permissions'));

        return Responser::success(new UserResource($user));
    }

    public function syncRoles(User $user, SyncRoleRequest $request): JsonResponse
    {
        $user = $this->userRepository->syncRolesById($user, $request->get('roles'));

        return Responser::success(new UserResource($user));
    }

    public function block(User $user, BlockOrUnblockRequest $request): JsonResponse
    {
        $user = $this->userRepository->blockOrUnblock($user, $request->validated());

        return Responser::success(new UserResource($user));
    }
}
