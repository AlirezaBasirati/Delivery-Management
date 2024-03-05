<?php

use App\Services\FleetService\Controllers\V1\Driver\DriverController;
use App\Services\FleetService\Controllers\V1\Driver\DriverLocationController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api')->group(function () {

    Route::middleware('auth:api')->prefix('driver/v1')->name('driver.')->group(function () {

        Route::post('drivers/activation', [DriverController::class, 'activation'])->name('activation');
        Route::post('driver-locations', [DriverLocationController::class, 'store'])->name('driver-locations.store');

    });
});

