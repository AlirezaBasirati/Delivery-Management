<?php

namespace App\Services\AuthenticationService\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Services\AuthenticationService\Models\User;
use App\Services\AuthenticationService\Repository\V1\Common\User\UserInterface;
use App\Services\AuthenticationService\Requests\V1\Admin\User\StoreRequest;
use App\Services\AuthenticationService\Requests\V1\Admin\User\UpdateRequest;
use App\Services\AuthenticationService\Resources\V1\Common\User\BriefUserResource;
use App\Services\AuthenticationService\Resources\V1\Common\User\UserResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private readonly UserInterface $userRepository)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $users = $this->userRepository->index($request->query());

        return Responser::collection(BriefUserResource::collection($users));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $user = $this->userRepository->store($request->validated());

        return Responser::success(new UserResource($user));
    }

    public function update(User $user, UpdateRequest $request): JsonResponse
    {
        $user = $this->userRepository->update($user, $request->validated());

        return Responser::success(new UserResource($user));
    }

    public function show(User $user): JsonResponse
    {
        $user = $this->userRepository->show($user);

        return Responser::info(new UserResource($user));
    }

    public function destroy(User $user): JsonResponse
    {
        $this->userRepository->destroy($user);

        return Responser::deleted();
    }
}
