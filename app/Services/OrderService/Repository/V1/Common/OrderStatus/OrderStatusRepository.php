<?php

namespace App\Services\OrderService\Repository\V1\Common\OrderStatus;

use App\Services\OrderService\Models\OrderStatus;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class OrderStatusRepository extends BaseRepository implements OrderStatusInterface
{
    public function __construct(OrderStatus $model)
    {
        return parent::__construct($model);
    }

    public function ordersCount(): Collection
    {
        return $this->model->query()
            ->with('orders')
            ->get();
    }
}
