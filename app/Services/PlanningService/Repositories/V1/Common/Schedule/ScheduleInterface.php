<?php

namespace App\Services\PlanningService\Repositories\V1\Common\Schedule;

use App\Services\PlanningService\Models\Schedule;
use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ScheduleInterface extends BaseRepositoryInterface
{
    public function store(array $parameters): Model;

    public function calendar(array $parameters): Collection|array;

    public function calendarResult($schedules): array;

    public function plan(array $parameters): void;

    public function assignVehicles(Schedule $schedule, array $parameters): void;

    public function reserve(Schedule $schedule, array $parameters): void;
}
