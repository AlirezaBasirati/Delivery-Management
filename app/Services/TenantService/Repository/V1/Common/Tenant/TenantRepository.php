<?php

namespace App\Services\TenantService\Repository\V1\Common\Tenant;

use App\Services\TenantService\Models\Tenant;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class TenantRepository extends BaseRepository implements TenantInterface
{
    public function __construct(private readonly Tenant $tenant)
    {
        parent::__construct($this->tenant);
    }


    public function findByKey(string $key): Model|null
    {
        return $this->tenant->query()
            ->where('key', $key)
            ->first();
    }
}
