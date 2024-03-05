<?php

namespace App\Services\AuthorizationService\Observers;

use App\Services\AuthorizationService\Models\Permission;

class PermissionObserver
{
    public function created(Permission $permission): void
    {
        $permission->refreshCache();
    }

    public function updated(Permission $permission): void
    {
        $permission->refreshCache();
    }

    public function deleted(Permission $permission): void
    {
        $permission->refreshCache();
    }
}
