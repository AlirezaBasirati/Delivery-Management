<?php

namespace App\Services\TenantService\Database\Seeders;

use App\Services\AuthenticationService\Models\User;
use App\Services\TenantService\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    public function run()
    {
        Tenant::factory()
            ->state([
                'webhook_url' => 'https://core-gw-dev.zoot24.com/api/external/v1/order/orders/webhook',
                'name'        => 'zoot',
                'key'         => 'zoot'
            ])
            ->create();
    }
}
