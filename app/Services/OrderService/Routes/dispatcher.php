<?php

use App\Services\OrderService\Controllers\V1\Common\OrderStatusController;
use App\Services\OrderService\Controllers\V1\Common\OrderController;
use App\Services\OrderService\Controllers\V2\Dispatcher\OrderController as OrderControllerV2;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth:api'])->prefix('api/dispatcher')->name('dispatcher.')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::post('/', [OrderController::class, 'store'])->name('store');
            Route::get('count', [OrderController::class, 'count'])->name('count');
            Route::post('assign-driver', [OrderController::class, 'bulkAssignDriver'])->name('bulk-assign-driver');
            Route::post('dispatch', [OrderController::class, 'bulkDispatch'])->name('bulk-dispatch');
            Route::get('{order}/map', [OrderController::class, 'showOnMap'])->name('map');
            Route::post('{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
            Route::post('{order}/assign-driver/{driver}', [OrderController::class, 'assignDriver'])->name('assign-driver');
            Route::post('{order}/un-assign-driver', [OrderController::class, 'unAssignDriver'])->name('un-assign-driver');
            Route::post('{order}/broadcast', [OrderController::class, 'broadcast'])->name('broadcast');
        });


        Route::prefix('order-statuses')->name('order_statuses.')->group(function () {
            Route::get('orders-count', [OrderStatusController::class, 'ordersCount'])->name('orders-count');
        });
    });
    Route::prefix('v2')->group(function () {
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderControllerV2::class, 'index'])->name('index');
        });
    });
});

