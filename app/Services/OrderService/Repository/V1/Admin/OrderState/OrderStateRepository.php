<?php

namespace App\Services\OrderService\Repository\V1\Admin\OrderState;

use App\Services\OrderService\Models\OrderState;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderStateRepository extends BaseRepository implements OrderStateInterface
{
    public function __construct(OrderState $model)
    {
        return parent::__construct($model);
    }

    public function conditions(Builder $query): array
    {
        return [
            'title' => '=',
        ];
    }

    public function destroy(Model $model): bool
    {
        DB::beginTransaction();

        $model->orderStatuses()->delete();
        $deleted = $model->delete();

        DB::commit();

        return $deleted;
    }
}
