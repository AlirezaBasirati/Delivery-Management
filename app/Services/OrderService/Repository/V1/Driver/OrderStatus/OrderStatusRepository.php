<?php

namespace App\Services\OrderService\Repository\V1\Driver\OrderStatus;

use App\Services\OrderService\Models\OrderStatus;
use Celysium\Base\Repository\BaseRepository;

class OrderStatusRepository extends BaseRepository implements OrderStatusInterface
{
    public function __construct(OrderStatus $model)
    {
        return parent::__construct($model);
    }
}
