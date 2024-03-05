<?php

namespace App\Services\PlanningService\Repositories\V1\Common\ReservedSchedule;

use Celysium\Base\Repository\BaseRepositoryInterface;

interface ReservedScheduleInterface extends BaseRepositoryInterface
{
    public function checkReserve(array $conditions, bool $withDelete = false): bool;
}
