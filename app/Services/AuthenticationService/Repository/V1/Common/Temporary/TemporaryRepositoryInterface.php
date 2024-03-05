<?php

namespace App\Services\AuthenticationService\Repository\V1\Common\Temporary;

use App\Services\AuthenticationService\Models\Temporary;
use Celysium\Base\Repository\BaseRepositoryInterface;

interface TemporaryRepositoryInterface extends BaseRepositoryInterface
{
    public function findByColumn(string $column, string $username): ?Temporary;

    public function sendOTP(string $column, string $username): bool;

    public function check(string $column, string $username, string $code);
}
