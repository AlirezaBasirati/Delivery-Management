<?php

namespace App\Services\OrderService\Repository\V1\Admin\OrderStatus;

use App\Services\OrderService\Models\OrderStatus;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderStatusRepository extends BaseRepository implements OrderStatusInterface
{
    public function __construct(OrderStatus $model)
    {
        return parent::__construct($model);
    }

    public function conditions(Builder $query): array
    {
        return [
            'title'    => '=',
            'state_id' => '='
        ];
    }

    public function store(array $parameters): \Illuminate\Database\Eloquent\Model
    {
        DB::beginTransaction();

        $this->model->query()
            ->where('sort', '>=', $parameters['sort'])
            ->increment('sort');

        $result = parent::store($parameters);

        DB::commit();

        return $result;
    }

    public function update(Model $model, array $parameters): Model
    {
        DB::beginTransaction();

        if (isset($parameters['sort'])) {
            $parameters['sort'] = (int)$parameters['sort'];

            if ($model->sort > $parameters['sort']) {
                $this->model->query()
                    ->where(function ($query) use ($parameters, $model) {
                        $query->where('sort', '<', $model->sort)
                            ->where('sort', '>=', $parameters['sort']);
                    })
                    ->increment('sort');
            } else {
                $this->model->query()
                    ->where(function ($query) use ($parameters, $model) {
                        $query->where('sort', '>', $model->sort)
                            ->where('sort', '<=', $parameters['sort']);
                    })
                    ->decrement('sort');
            }
        }

        $result = parent::update($model, $parameters);

        DB::commit();

        return $result;
    }

    public function destroy(Model $model): bool
    {
        DB::beginTransaction();

        $this->model->query()
            ->where('sort', '>', $model->sort)
            ->decrement('sort');

        $result = parent::destroy($model);

        DB::commit();

        return $result;
    }
}
