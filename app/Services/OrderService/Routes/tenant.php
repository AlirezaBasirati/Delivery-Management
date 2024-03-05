<?php

use App\Services\OrderService\Controllers\V1\Common\OrderController as CommonOrderController;
use App\Services\OrderService\Controllers\V1\Tenant\OrderController;
use App\Services\OrderService\Controllers\V1\Tenant\OrderStatusLogController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth:api'])->prefix('api/tenant/v1')->name('tenant.')->group(function () {

    Route::prefix('orders')->name('orders')->group(function () {
        Route::post('/', [CommonOrderController::class, 'store'])->name('store');
        Route::post('{code}/cancel', [OrderController::class, 'cancel'])->name('cancel');
        Route::get('{order}', [OrderController::class, 'show'])->name('show');
    });

    Route::get('order-status-logs', [OrderStatusLogController::class, 'index'])->name('orders-status-logs.get');

});

