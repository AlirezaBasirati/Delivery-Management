<?php

namespace App\Services\MessageService\Repository\V1\Common\StaticMessageGroup;

use App\Services\MessageService\Models\StaticMessageGroup;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class StaticMessageGroupRepository extends BaseRepository implements StaticMessageGroupInterface
{
    public function __construct(StaticMessageGroup $model)
    {
        return parent::__construct($model);
    }

    public function conditions(Builder $query): array
    {
        return [
            'id'        => '=',
            'reserve'   => '=',
            'name'      => 'like',
            'title'     => 'like',
            'parent_id' => '='
        ];
    }
}
