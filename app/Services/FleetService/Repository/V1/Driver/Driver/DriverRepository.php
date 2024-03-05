<?php

namespace App\Services\FleetService\Repository\V1\Driver\Driver;

use App\Services\AuthenticationService\Models\User;
use App\Services\FleetService\Models\Driver;
use Celysium\Base\Repository\BaseRepository;

class DriverRepository extends BaseRepository implements DriverInterface
{
    public function __construct(Driver $model)
    {
        return parent::__construct($model);
    }

    public function activation(User $user, array $parameters): void
    {
        $driver = $user->driver;

        $driver->status = $parameters['status'];
        $driver->save();
    }
}
