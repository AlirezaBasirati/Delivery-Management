<?php

namespace App\Services\AuthorizationService\Observers;

use App\Services\AuthorizationService\Models\Role;

class RoleObserver
{
    public function created(Role $role): void
    {
        $role->refreshCache();
    }

    public function updated(Role $role): void
    {
        $role->refreshCache();
    }

    public function deleted(Role $role): void
    {
        $role->refreshCache();
    }
}
