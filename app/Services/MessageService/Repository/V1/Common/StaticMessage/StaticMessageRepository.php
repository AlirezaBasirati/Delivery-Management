<?php

namespace App\Services\MessageService\Repository\V1\Common\StaticMessage;

use App\Services\MessageService\Models\StaticMessage;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class StaticMessageRepository extends BaseRepository implements StaticMessageInterface
{
    public function __construct(StaticMessage $model)
    {
        return parent::__construct($model);
    }

    public function conditions(Builder $query): array
    {
        return [
            'group_id' => '='
        ];
    }
}
