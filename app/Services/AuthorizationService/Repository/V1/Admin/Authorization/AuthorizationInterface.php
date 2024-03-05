<?php

namespace App\Services\AuthorizationService\Repository\V1\Admin\Authorization;

interface AuthorizationInterface
{
    public function access(): array;
}
