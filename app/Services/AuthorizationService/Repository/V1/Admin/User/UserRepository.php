<?php

namespace App\Services\AuthorizationService\Repository\V1\Admin\User;

use App\Services\AuthenticationService\Models\User;
use Celysium\Base\Repository\BaseRepository;

class UserRepository extends BaseRepository implements UserInterface
{
    public function __construct(User $model)
    {
        return parent::__construct($model);
    }

    public function syncRolesById(User $user, array $parameters): User
    {
        $user->update(['role_id' => $parameters['role']]);

        return $user->refresh();
    }

    public function syncPermissionsById(User $user, array $parameters): User
    {
        $permissions = [];
        foreach ($parameters as $permission) {
            $permissions[$permission['id']] = ['is_able' => $permission['is_able']];
        }

        $user->permissions()->syncWithoutDetaching($permissions);

        return $user;
    }

    public function blockOrUnblock(User $user, array $parameters): User
    {
        $user->update($parameters);

        return $user;
    }
}
