<?php

namespace App\Services\OrderService\Repository\V1\Admin\OrderState;

use App\Services\FleetService\Models\Driver;
use App\Services\OrderService\Models\Order;
use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface OrderStateInterface extends BaseRepositoryInterface
{
    public function destroy(Model $model): bool;
}
