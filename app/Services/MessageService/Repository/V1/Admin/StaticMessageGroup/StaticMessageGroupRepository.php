<?php

namespace App\Services\MessageService\Repository\V1\Admin\StaticMessageGroup;

use App\Services\MessageService\Models\StaticMessageGroup;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StaticMessageGroupRepository extends BaseRepository implements StaticMessageGroupInterface
{
    public function __construct(StaticMessageGroup $model)
    {
        return parent::__construct($model);
    }

    public function conditions(Builder $query): array
    {
        return [
            'reserve' => '=',
            'name'    => 'like',
            'title'   => 'like'
        ];
    }

    public function destroy(Model $model): bool
    {
        DB::beginTransaction();

        /** @var StaticMessageGroup $model */
        $model->messages()->delete();
        $result = parent::destroy($model);

        DB::commit();

        return $result;
    }
}
