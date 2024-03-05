<?php

namespace App\Services\AuthorizationService\Repository\V1\Admin\Authorization;

use App\Services\AuthenticationService\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthorizationRepository implements AuthorizationInterface
{

    public function access(): array
    {
        /** @var User $user */
        $user = Auth::user();

        return $user->cachePermissions();
    }

}
