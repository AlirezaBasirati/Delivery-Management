<?php

namespace App\Services\OrderService\Repository\V1\Admin\OrderStatus;

use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface OrderStatusInterface extends BaseRepositoryInterface
{
    public function store(array $parameters): Model;

    public function update(Model $model, array $parameters): Model;

    public function destroy(Model $model): bool;
}
