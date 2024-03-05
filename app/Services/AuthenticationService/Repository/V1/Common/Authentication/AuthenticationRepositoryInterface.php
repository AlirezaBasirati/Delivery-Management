<?php

namespace App\Services\AuthenticationService\Repository\V1\Common\Authentication;

use App\Services\AuthenticationService\Models\User;
use Celysium\Base\Repository\BaseRepositoryInterface;

interface AuthenticationRepositoryInterface extends BaseRepositoryInterface
{
    public function login(array $parameters): array;

    public function logout(): bool;

    public function check(array $parameters);

    public function verify(array $parameters);

    public function forget(array $parameters);

    public function reset(array $parameters);

    public function changePassword(array $parameters): bool;

    public function setPassword(array $parameters): array;

    public function me(): User;

    public function refresh(array $parameters): array;

}
