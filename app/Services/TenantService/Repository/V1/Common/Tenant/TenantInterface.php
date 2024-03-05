<?php

namespace App\Services\TenantService\Repository\V1\Common\Tenant;

use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface TenantInterface extends BaseRepositoryInterface
{
    public function findByKey(string $key): Model|null;
}
