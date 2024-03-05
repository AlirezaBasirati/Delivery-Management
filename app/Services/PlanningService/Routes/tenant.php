<?php

use App\Services\PlanningService\Controllers\V1\Common\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth:api'])->prefix('api/tenant/v1')->name('tenant.')->group(function () {
    Route::post('schedules/{schedule}/reserve', [ScheduleController::class, 'reserve'])->name('schedules.reserve');
});

