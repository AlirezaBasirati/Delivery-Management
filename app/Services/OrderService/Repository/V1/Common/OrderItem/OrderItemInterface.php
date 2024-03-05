<?php

namespace App\Services\OrderService\Repository\V1\Common\OrderItem;

use App\Services\FleetService\Models\Driver;
use App\Services\OrderService\Models\Order;
use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface OrderItemInterface extends BaseRepositoryInterface
{
    public function storeMany(array $parameters): bool;
}
