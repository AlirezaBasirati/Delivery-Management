<?php

use App\Services\PlanningService\Controllers\V1\Common\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth:api'])->prefix('api/customer/v1')->name('customer.')->group(function () {
    Route::post('schedules/{schedule}/reserve', [ScheduleController::class, 'reserve']);
});

