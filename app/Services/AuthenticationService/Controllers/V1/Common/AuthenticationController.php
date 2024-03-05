<?php

namespace App\Services\AuthenticationService\Controllers\V1\Common;

use App\Http\Controllers\Controller;
use App\Services\AuthenticationService\Repository\V1\Common\Authentication\AuthenticationRepositoryInterface;
use App\Services\AuthenticationService\Requests\V1\Common\Authentication\ChangePasswordRequest;
use App\Services\AuthenticationService\Requests\V1\Common\Authentication\CheckRequest;
use App\Services\AuthenticationService\Requests\V1\Common\Authentication\LoginRequest;
use App\Services\AuthenticationService\Requests\V1\Common\Authentication\RefreshRequest;
use App\Services\AuthenticationService\Requests\V1\Common\Authentication\ResetRequest;
use App\Services\AuthenticationService\Requests\V1\Common\Authentication\SetPasswordRequest;
use App\Services\AuthenticationService\Requests\V1\Common\Authentication\StoreRequest;
use App\Services\AuthenticationService\Requests\V1\Common\Authentication\UpdateRequest;
use App\Services\AuthenticationService\Requests\V1\Common\Authentication\VerifyRequest;
use App\Services\AuthenticationService\Resources\V1\Common\User\UserResource;
use Celysium\Responser\Responser;
use Exception;
use Illuminate\Http\JsonResponse;

class AuthenticationController extends Controller
{
    public function __construct(private readonly AuthenticationRepositoryInterface $authenticationService)
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authenticationService->login($request->validated());

        return Responser::success(
            [
                'user'  => new UserResource($result['user']),
                'auth' => $result['auth']
            ]
        );
    }

    public function logout(): JsonResponse
    {
        $this->authenticationService->logout();

        return Responser::success();
    }

    /**
     * @param CheckRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function check(CheckRequest $request): JsonResponse
    {
        $result = $this->authenticationService->check($request->validated());

        return Responser::info($result);
    }

    /**
     * @param VerifyRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function verify(VerifyRequest $request): JsonResponse
    {
        $result = $this->authenticationService->verify($request->validated());

        return Responser::success([
            'auth' => $result['auth'],
            'user' => new UserResource($result['user'])
        ]);
    }

    /**
     * @param CheckRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function forget(CheckRequest $request): JsonResponse
    {
        $this->authenticationService->forget($request->validated());

        return Responser::success([], [[
            'type' => 'success',
            'text' => __('messages.otp_send_successful')
        ]]);
    }

    /**
     * @param ResetRequest $request
     * @return JsonResponse
     */
    public function reset(ResetRequest $request): JsonResponse
    {
        $result = $this->authenticationService->reset($request->validated());

        return Responser::success(['code' => $result]);
    }

    /**
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $this->authenticationService->changePassword($request->validated());

        return Responser::success();
    }

    /**
     * @param SetPasswordRequest $request
     * @return JsonResponse
     */
    public function setPassword(SetPasswordRequest $request): JsonResponse
    {
        $result = $this->authenticationService->setPassword($request->validated());

        return Responser::success([
            'auth' => $result['auth'],
            'user' => $result['user']
        ]);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $result = $this->authenticationService->store($request->validated());

        return Responser::success([
            'user'  => new UserResource($result['user']),
            'auth' => $result['auth']
        ]);
    }

    public function me(): JsonResponse
    {
        $user = $this->authenticationService->me();

        return Responser::info(new UserResource($user));
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        $user = $this->authenticationService->update($request->user(), $request->validated());

        return Responser::success(new UserResource($user));
    }

    public function refresh(RefreshRequest $request): JsonResponse
    {
        $result = $this->authenticationService->refresh($request->validated());

        return Responser::success($result);
    }
}
