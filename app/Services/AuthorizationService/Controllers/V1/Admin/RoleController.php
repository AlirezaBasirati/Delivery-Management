<?php

namespace App\Services\AuthorizationService\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Services\AuthorizationService\Models\Role;
use App\Services\AuthorizationService\Repository\V1\Admin\Role\RoleInterface;
use App\Services\AuthorizationService\Requests\V1\Admin\Role\DestroyRequest;
use App\Services\AuthorizationService\Requests\V1\Admin\Role\StoreRequest;
use App\Services\AuthorizationService\Requests\V1\Admin\Role\SyncPermissionRequest;
use App\Services\AuthorizationService\Requests\V1\Admin\Role\UpdateRequest;
use App\Services\AuthorizationService\Resources\V1\Admin\Role\BriefRoleResource;
use App\Services\AuthorizationService\Resources\V1\Admin\Role\RoleResource;
use Celysium\Responser\Responser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct(protected RoleInterface $repository)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $roles = $this->repository->index($request->all());

        return Responser::collection(BriefRoleResource::collection($roles));
    }

    public function show(Role $role): Model|JsonResponse
    {
        $role = $this->repository->show($role);

        return Responser::created(new RoleResource($role));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $role = $this->repository->store($request->all());

        return Responser::created(new RoleResource($role));
    }

    public function update(Role $role, UpdateRequest $request): JsonResponse
    {
        $role = $this->repository->update($role, $request->all());

        return Responser::success(new RoleResource($role));
    }

    public function destroy(Role $role, DestroyRequest $request): JsonResponse
    {
        $this->repository->destroy($role);

        return Responser::deleted();
    }

    public function syncPermissions(Role $role, SyncPermissionRequest $request): JsonResponse
    {
        $this->repository->assignPermissions($role, $request->all());

        return Responser::info(new RoleResource($role->refresh()));
    }
}
