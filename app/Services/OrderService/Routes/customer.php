<?php

use App\Services\OrderService\Controllers\V1\Common\OrderController as CommonOrderController;
use App\Services\OrderService\Controllers\V1\Customer\OrderController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api')->group(function () {
    Route::middleware('auth:api')->prefix('customer/v1')->name('customer.')->group(function () {
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('currents', [OrderController::class, 'currents'])->name('currents');
            Route::post('/', [CommonOrderController::class, 'store'])->name('store');
            Route::get('{order}', [OrderController::class, 'show'])->name('get');
            Route::post('{order}/cancel', [CommonOrderController::class, 'cancel'])->name('cancel');
            Route::post('{order}/drop-off', [CommonOrderController::class, 'addDropOffToOrder'])->name('add-drop-off-to-order');
            Route::post('{order}/hurry', [OrderController::class, 'hurry'])->name('hurry');

        });
    });
});

