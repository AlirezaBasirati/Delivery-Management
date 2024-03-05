<?php

namespace App\Services\AuthorizationService\Repository\V1\Admin\Role;

use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface RoleInterface extends BaseRepositoryInterface
{
    public function store(array $parameters): Model;

    public function update(Model $model, array $parameters): Model;
}
