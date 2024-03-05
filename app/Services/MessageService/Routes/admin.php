<?php

use App\Services\MessageService\Controllers\V1\Admin\StaticMessageController;
use App\Services\MessageService\Controllers\V1\Admin\StaticMessageGroupController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth:api'])->prefix('api/admin/v1')->name('admin.')->group(function () {

    Route::apiResource('static-messages', StaticMessageController::class);

    Route::apiResource('static-message-groups', StaticMessageGroupController::class);

});

