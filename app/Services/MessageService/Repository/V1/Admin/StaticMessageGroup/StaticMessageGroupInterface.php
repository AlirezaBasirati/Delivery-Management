<?php

namespace App\Services\MessageService\Repository\V1\Admin\StaticMessageGroup;

use App\Services\FleetService\Models\Driver;
use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface StaticMessageGroupInterface extends BaseRepositoryInterface
{
    public function destroy(Model $model): bool;
}
