<?php

namespace App\Services\PlanningService\Repositories\V1\Common\ReservedSchedule;

use App\Services\PlanningService\Models\ReservedSchedule;
use Celysium\Base\Repository\BaseRepository;

class ReservedScheduleRepository extends BaseRepository implements ReservedScheduleInterface
{
    public function __construct(ReservedSchedule $model)
    {
        return parent::__construct($model);
    }

    public function checkReserve(array $conditions, bool $withDelete = false): bool
    {
        $rows = $this->model->query()->where($conditions);

        $exists = $rows->clone()->exists();

        if ($withDelete) {
            $rows->delete();
        }

        return $exists;
    }
}
