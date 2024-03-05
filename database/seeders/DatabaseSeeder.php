<?php

namespace Database\Seeders;

use App\Services\AuthenticationService\Database\Seeders\OauthClientSeeder;
use App\Services\AuthenticationService\Database\Seeders\UserSeeder;
use App\Services\AuthorizationService\Database\Seeders\RoleSeeder;
use App\Services\AuthorizationService\Database\Seeders\RoleUserSeeder;
use App\Services\CustomerService\Database\Seeders\CustomerSeeder;
use App\Services\FleetService\Database\Seeders\DriverSeeder;
use App\Services\FleetService\Database\Seeders\VehicleSeeder;
use App\Services\FleetService\Database\Seeders\VehicleTypeSeeder;
use App\Services\MessageService\Database\Seeders\StaticMessageGroupSeeder;
use App\Services\MessageService\Database\Seeders\StaticMessageSeeder;
use App\Services\OrderService\Database\Seeders\OrderSeeder;
use App\Services\OrderService\Database\Seeders\OrderStateSeeder;
use App\Services\OrderService\Database\Seeders\OrderStatusSeeder;
use App\Services\PlanningService\Database\Seeders\ScheduleSeeder;
use App\Services\PlanningService\Database\Seeders\TemplateSeeder;
use App\Services\PlanningService\Database\Seeders\TimeSlotSeeder;
use App\Services\TenantService\Database\Seeders\TenantSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            OauthClientSeeder::class,
            TenantSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            VehicleTypeSeeder::class,
            VehicleSeeder::class,
            DriverSeeder::class,
            OrderStateSeeder::class,
            OrderStatusSeeder::class,
            OrderSeeder::class,
            StaticMessageGroupSeeder::class,
            StaticMessageSeeder::class,
            CustomerSeeder::class,
            TimeSlotSeeder::class,
            TemplateSeeder::class,
            ScheduleSeeder::class
        ]);
    }
}
