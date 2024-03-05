<?php

namespace App\Services\OrderService\Repository\V1\Common\OrderItem;

use App\Services\OrderService\Libraries\ArrayOptions;
use App\Services\OrderService\Models\OrderItem;
use Celysium\Base\Repository\BaseRepository;

class OrderItemRepository extends BaseRepository implements OrderItemInterface
{
    public function __construct(OrderItem $model)
    {
        return parent::__construct($model);
    }

    public function storeMany(array $parameters): bool
    {
        $now = now();

        ArrayOptions::pushToItems($parameters, [
            'created_at' => $now,
            'updated_at' => $now
        ]);

        return $this->model->query()->insert($parameters);
    }
}
