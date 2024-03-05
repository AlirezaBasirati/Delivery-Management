<?php

namespace App\Services\OrderService\Repository\V1\Tenant\OrderStatusLog;

use App\Services\OrderService\Models\OrderStatusLog;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class OrderStatusLogRepository extends BaseRepository implements OrderStatusLogInterface
{
    public function __construct(OrderStatusLog $model)
    {
        return parent::__construct($model);
    }

    public function conditions(Builder $query): array
    {
        return [
            'order_id' => fn($value) => $query->where('order_id', $value)
        ];
    }
}
