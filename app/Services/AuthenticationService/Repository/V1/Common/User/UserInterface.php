<?php

namespace App\Services\AuthenticationService\Repository\V1\Common\User;

use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;


interface UserInterface extends BaseRepositoryInterface
{
    public function store(array $parameters): Model;

    public function update(Model $model, array $parameters): Model;

    public function destroy(Model $model): bool;
}
