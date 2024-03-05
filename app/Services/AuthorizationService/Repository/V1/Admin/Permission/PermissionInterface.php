<?php

namespace App\Services\AuthorizationService\Repository\V1\Admin\Permission;

use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface PermissionInterface extends BaseRepositoryInterface
{
    public function store(array $parameters): Model;

    public function update(Model $model, array $parameters): Model;

    public function destroy(Model $model): bool;
}
