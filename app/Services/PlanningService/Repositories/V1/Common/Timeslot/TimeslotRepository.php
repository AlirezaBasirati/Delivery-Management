<?php

namespace App\Services\PlanningService\Repositories\V1\Common\Timeslot;

use App\Services\PlanningService\Models\Timeslot;
use Celysium\Base\Repository\BaseRepository;

class TimeslotRepository extends BaseRepository implements TimeslotInterface
{
    public function __construct(Timeslot $model)
    {
        return parent::__construct($model);
    }
}
