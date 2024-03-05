<?php

use App\Services\AuthenticationService\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return true;
//    return (int) $user->id === (int) $id;
});

Broadcast::channel('notification.user.{id}', function (User $user, $id) {
    return true;
//    return $user->id === (int) $id;
});
