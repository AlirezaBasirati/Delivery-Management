<?php

namespace App\Services\PlanningService\Providers;

use App\Services\PlanningService\Repositories\V1\Common\ReservedSchedule\ReservedScheduleInterface;
use App\Services\PlanningService\Repositories\V1\Common\ReservedSchedule\ReservedScheduleRepository;
use App\Services\PlanningService\Repositories\V1\Common\Schedule\ScheduleInterface;
use App\Services\PlanningService\Repositories\V1\Common\Schedule\ScheduleRepository;
use App\Services\PlanningService\Repositories\V1\Common\Template\TemplateInterface;
use App\Services\PlanningService\Repositories\V1\Common\Template\TemplateRepository;
use App\Services\PlanningService\Repositories\V1\Common\TemplateItem\TemplateItemInterface;
use App\Services\PlanningService\Repositories\V1\Common\TemplateItem\TemplateItemRepository;
use App\Services\PlanningService\Repositories\V1\Common\Timeslot\TimeslotInterface;
use App\Services\PlanningService\Repositories\V1\Common\Timeslot\TimeslotRepository;
use Illuminate\Support\ServiceProvider;

class PlanningServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TemplateInterface::class, TemplateRepository::class);
        $this->app->bind(TemplateItemInterface::class, TemplateItemRepository::class);
        $this->app->bind(TimeslotInterface::class, TimeslotRepository::class);
        $this->app->bind(ScheduleInterface::class, ScheduleRepository::class);
        $this->app->bind(ReservedScheduleInterface::class, ReservedScheduleRepository::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/../Routes/customer.php');
        $this->loadRoutesFrom(__DIR__.'/../Routes/dispatcher.php');
        $this->loadRoutesFrom(__DIR__.'/../Routes/tenant.php');
    }
}
