<?php

namespace App\Services\OrderService\Repository\V1\Admin\Order;

use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Repository\V1\Common\Order\OrderInterface as CommonOrderInterface;
use App\Services\OrderService\Repository\V1\Common\OrderStatusLog\OrderStatusLogInterface;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderRepository extends BaseRepository implements OrderInterface
{
    public function __construct(
        Order                                 $model,
        private readonly CommonOrderInterface $commonOrderService,
        private readonly OrderStatusLogInterface $orderStatusLogService
    )
    {
        return parent::__construct($model);
    }

    public function conditions(Builder $query): array
    {
        return [
            'id'           => '=',
            'ids'          => fn($value) => $query->whereIn('id', $value),
            'created_from' => fn($value) => $query->where('created_at', '>=', $value),
            'created_to'   => fn($value) => $query->where('created_at', '<=', $value),
        ];
    }

    public function destroy(Model $model): bool
    {
        DB::beginTransaction();

        /** @var Order $model */
        if (isset($model->driver_id)) {
            $this->orderStatusLogService->store([
                'order_id' => $model->id,
                'order_status_id' => $this->commonOrderService->unAssignStatus($model)->value
            ]);
        }

        $model->items()->delete();
        $model->locations()->delete();
        $model->statusLogs()->delete();

        $result = parent::destroy($model);

        DB::commit();

        return $result;
    }

}
