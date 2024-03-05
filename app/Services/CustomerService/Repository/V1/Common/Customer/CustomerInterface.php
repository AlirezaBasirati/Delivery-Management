<?php

namespace App\Services\CustomerService\Repository\V1\Common\Customer;

use App\Services\CustomerService\Models\Customer;
use Celysium\Base\Repository\BaseRepositoryInterface;

interface CustomerInterface extends BaseRepositoryInterface
{
    public function getByMobile(string $mobile, array $conditions = []);

    public function checkMobileExists(string $mobile, array $conditions = []): bool;

    public function verify(Customer $customer, string $mobile): void;

    public function firstOrCreate(array $parameters): Customer;
}
