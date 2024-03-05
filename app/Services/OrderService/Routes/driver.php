<?php

use App\Services\OrderService\Controllers\V1\Driver\BroadcastOrderController;
use App\Services\OrderService\Controllers\V1\Driver\OrderController;
use App\Services\OrderService\Controllers\V2\Driver\OrderController as OrderControllerV2;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api')->group(function () {

    Route::middleware('auth:api')->prefix('driver')->name('driver.')->group(function () {
        Route::prefix('v1')->group(function () {

            Route::prefix('broadcast-orders')->name('broadcast-orders.')->group(function () {
                Route::get('un-assigned-count', [BroadcastOrderController::class, 'pendingCount'])->name('un-assigned-count');
            });

            Route::prefix('orders')->name('orders.')->group(function () {
                Route::get('/', [OrderController::class, 'index'])->name('index');
                Route::get('{order}/select', [OrderController::class, 'select'])->name('select');
                Route::get('current', [OrderController::class, 'current'])->name('current');
                Route::get('scheduled-list', [OrderController::class, 'scheduledList'])->name('scheduled-list');
                Route::get('current/items', [OrderController::class, 'items'])->name('current.items');
                Route::post('change-status', [OrderController::class, 'changeStatus'])->name('change-status');
                Route::post('accept', [OrderController::class, 'accept'])->name('accept');
                Route::post('un-assign', [OrderController::class, 'unAssign'])->name('un-assign');
                Route::post('return', [OrderController::class, 'return'])->name('return');
                Route::post('need-support', [OrderController::class, 'storeNeedSupportLog'])->name('need-support');
                Route::post('reorder-locations', [OrderController::class, 'reorderLocations'])->name('reorder-locations');
            });
        });
        Route::prefix('v2')->group(function () {

            Route::prefix('orders')->name('orders.')->group(function () {
                Route::get('/', [OrderControllerV2::class, 'index'])->name('index');
                Route::get('current', [OrderControllerV2::class, 'current'])->name('current');
            });
        });
    });
});

