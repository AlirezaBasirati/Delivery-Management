<?php

namespace App\Services\CustomerService\Providers;

use App\Services\CustomerService\Repository\V1\Common\Customer\CustomerInterface;
use App\Services\CustomerService\Repository\V1\Common\Customer\CustomerRepository;
use App\Services\CustomerService\Repository\V1\Customer\Bookmark\BookmarkInterface;
use App\Services\CustomerService\Repository\V1\Customer\Bookmark\BookmarkRepository;
use Illuminate\Support\ServiceProvider;

class CustomerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CustomerInterface::class, CustomerRepository::class);
        $this->app->bind(BookmarkInterface::class, BookmarkRepository::class);
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/tenant.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/customer.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
