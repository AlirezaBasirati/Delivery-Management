<?php

namespace App\Services\OrderService\Repository\V1\Common\OrderLocation;

use App\Services\OrderService\Models\Order;
use Celysium\Base\Repository\BaseRepositoryInterface;

interface OrderLocationInterface extends BaseRepositoryInterface
{
    public function storeMany(array $parameters): bool;

    public function addDropOffToOrder(Order $order, array $parameters);
}
