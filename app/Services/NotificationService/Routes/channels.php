<?php

use App\Services\AuthenticationService\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::routes(['middleware' => ['auth:api']]);

Broadcast::channel('notification.user.{id}', function (User $user, $id) {
    return true;
//    return $user->id === (int) $id;
});
