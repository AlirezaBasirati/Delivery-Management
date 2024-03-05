<?php

namespace App\Services\OrderService\Repository\V1\Common\OrderStatus;

use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface OrderStatusInterface extends BaseRepositoryInterface
{
    public function ordersCount();
}
