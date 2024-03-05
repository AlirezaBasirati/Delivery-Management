<?php

namespace App\Services\FleetService\Repository\V1\Driver\Driver;

use App\Services\AuthenticationService\Models\User;
use Celysium\Base\Repository\BaseRepositoryInterface;

interface DriverInterface extends BaseRepositoryInterface
{
    public function activation(User $user, array $parameters): void;
}
