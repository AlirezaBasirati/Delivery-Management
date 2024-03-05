<?php

namespace App\Services\OrderService\Repository\V1\Common\OrderStatusLog;

use App\Services\OrderService\Models\OrderStatusLog;
use Celysium\Base\Repository\BaseRepository;

class OrderStatusLogRepository extends BaseRepository implements OrderStatusLogInterface
{
    public function __construct(OrderStatusLog $model)
    {
        return parent::__construct($model);
    }
}
