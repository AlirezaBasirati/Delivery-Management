<?php

namespace App\Services\OrderService\Repository\V1\Admin\Order;

use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface OrderInterface extends BaseRepositoryInterface
{
    public function destroy(Model $model): bool;
}
