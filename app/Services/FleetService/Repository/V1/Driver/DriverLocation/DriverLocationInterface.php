<?php

namespace App\Services\FleetService\Repository\V1\Driver\DriverLocation;

use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface DriverLocationInterface extends BaseRepositoryInterface
{
    public function store(array $parameters): Model;
}
