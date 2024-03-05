<?php

use App\Services\FleetService\Controllers\V1\Admin\DriverLocationController;
use App\Services\FleetService\Controllers\V1\Common\DriverController;
use App\Services\FleetService\Controllers\V1\Common\VehicleController;
use App\Services\FleetService\Controllers\V1\Common\VehicleTypeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth:api'])->prefix('api/admin/v1')->name('admin.')->group(function () {

    Route::prefix('drivers/')->name('drivers.')->group(function () {
        Route::get('map', [DriverController::class, 'map'])->name('map');
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
            Route::prefix('drivers')->group(function () {
                Route::prefix('{driver}')->group(function () {
                    Route::post('/', [VehicleController::class, 'assignDriver'])->name('assign-driver');
                    Route::delete('/', [VehicleController::class, 'unAssignDriver'])->name('unAssign-driver');
                });
            });
        });
    });

    Route::apiResource('vehicles', VehicleController::class);

    Route::get('driver-locations', [DriverLocationController::class, 'index'])->name('driver-locations.get');

});

//function fleetSharedRoutes(): void
//{
//    dump(1);
//    Route::prefix('drivers/')->name('drivers.')->group(function () {
//        Route::get('map', [DriverController::class, 'map'])->name('map');
//        Route::get('select', [DriverController::class, 'select'])->name('select');
//
//        Route::prefix('{driver}')->group(function () {
//            Route::prefix('vehicles')->name('vehicles.')->group(function () {
//                Route::prefix('{vehicle}')->group(function () {
//                    Route::post('/', [DriverController::class, 'assignVehicle'])->name('assign-vehicle');
//                    Route::delete('/', [DriverController::class, 'unAssignVehicle'])->name('unAssign-vehicle');
//                });
//            });
//        });
//    });
//    Route::apiResource('drivers', DriverController::class);
//
//    Route::get('vehicle-types', [VehicleTypeController::class, 'index'])->name('vehicle-types.get');
//
//    Route::prefix('vehicles/')->name('vehicles.')->group(function () {
//        Route::get('select', [VehicleController::class, 'select'])->name('select');
//
//        Route::prefix('{vehicle}')->group(function () {
//            Route::prefix('drivers')->group(function () {
//                Route::prefix('{driver}')->group(function () {
//                    Route::post('/', [VehicleController::class, 'assignDriver'])->name('assign-driver');
//                    Route::delete('/', [VehicleController::class, 'unAssignDriver'])->name('unAssign-driver');
//                });
//            });
//        });
//    });
//
//    Route::apiResource('vehicles', VehicleController::class);
//}
