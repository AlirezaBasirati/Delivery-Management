<?php

namespace App\Services\OrderService\Repository\V1\Common\OrderStatusLog;

use App\Services\OrderService\Models\Order;
use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface OrderStatusLogInterface extends BaseRepositoryInterface
{
    public function store(array $parameters): Model;
}
