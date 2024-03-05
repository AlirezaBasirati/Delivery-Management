<?php

namespace App\Services\AuthorizationService\Repository\V1\Admin\User;

use App\Services\AuthenticationService\Models\User;
use Celysium\Base\Repository\BaseRepositoryInterface;


interface UserInterface extends BaseRepositoryInterface
{
    public function syncRolesById(User $user, array $parameters): User;

    public function syncPermissionsById(User $user, array $parameters): User;

    public function blockOrUnblock(User $user, array $parameters): User;
}
