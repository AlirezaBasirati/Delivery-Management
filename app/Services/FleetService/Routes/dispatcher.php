<?php

use App\Services\FleetService\Controllers\V1\Common\DriverController;
use App\Services\FleetService\Controllers\V1\Common\VehicleController;
use App\Services\FleetService\Controllers\V1\Common\VehicleTypeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth:api'])->prefix('api/dispatcher/v1')->name('dispatcher.')->group(function () {
    Route::prefix('drivers/')->name('drivers.')->group(function () {
        Route::get('map', [DriverController::class, 'map'])->name('map');
        Route::get('count', [DriverController::class, 'count'])->name('count');
        Route::get('select', [DriverController::class, 'select'])->name('select');

        Route::prefix('{driver}')->group(function () {
            Route::prefix('vehicles')->name('vehicles.')->group(function () {
                Route::prefix('{vehicle}')->group(function () {
                    Route::post('/', [DriverController::class, 'assignVehicle'])->name('assign-vehicle');
                    Route::delete('/', [DriverController::class, 'unAssignVehicle'])->name('unAssign-vehicle');
                });
            });
        });
    });
    Route::apiResource('drivers', DriverController::class);

    Route::get('vehicle-types', [VehicleTypeController::class, 'index'])->name('vehicle-types.get');

    Route::prefix('vehicles/')->name('vehicles.')->group(function () {
        Route::get('select', [VehicleController::class, 'select'])->name('select');

        Route::prefix('{vehicle}')->group(function () {
            Route::post('assign-schedules', [VehicleController::class, 'assignSchedules'])->name('assign-schedules');
            Route::prefix('drivers')->group(function () {
                Route::prefix('{driver}')->group(function () {
                    Route::post('/', [VehicleController::class, 'assignDriver'])->name('assign-driver');
                    Route::delete('/', [VehicleController::class, 'unAssignDriver'])->name('unAssign-driver');
                });
            });
        });
    });

    Route::apiResource('vehicles', VehicleController::class);
});

