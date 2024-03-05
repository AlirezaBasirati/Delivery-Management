<?php

namespace App\Services\AuthorizationService\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Services\AuthorizationService\Models\Permission;
use App\Services\AuthorizationService\Repository\V1\Admin\Permission\PermissionInterface;
use App\Services\AuthorizationService\Requests\V1\Admin\Permission\StoreRequest;
use App\Services\AuthorizationService\Requests\V1\Admin\Permission\UpdateRequest;
use App\Services\AuthorizationService\Resources\V1\Admin\Permission\BriefPermissionResource;
use App\Services\AuthorizationService\Resources\V1\Admin\Permission\PermissionResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct(protected PermissionInterface $repository)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $permissions = $this->repository->index($request->all());

        return Responser::collection(BriefPermissionResource::collection($permissions));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $permission = $this->repository->store($request->all());

        return Responser::created(new PermissionResource($permission));
    }

    public function show(Permission $permission): JsonResponse
    {
        $permission = $this->repository->show($permission);

        return Responser::info(new PermissionResource($permission));
    }

    public function update(UpdateRequest $request, Permission $permission): JsonResponse
    {
        $permission = $this->repository->update($permission, $request->all());

        return Responser::info(new PermissionResource($permission));
    }

    public function destroy(Permission $permission): JsonResponse
    {
        $this->repository->destroy($permission);

        return Responser::deleted();
    }
}
