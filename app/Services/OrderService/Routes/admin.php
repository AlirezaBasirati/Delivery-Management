<?php

use App\Services\OrderService\Controllers\V1\Admin\OrderController;
use App\Services\OrderService\Controllers\V1\Common\OrderController as CommonOrderController;
use App\Services\OrderService\Controllers\V1\Admin\OrderStateController;
use App\Services\OrderService\Controllers\V1\Admin\OrderStatusController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api')->group(function () {
    Route::middleware(['auth:api'])->prefix('admin/v1')->name('admin.')->group(function () {

        Route::apiResource('order-statuses', OrderStatusController::class);
        Route::apiResource('order-states', OrderStateController::class);

        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [CommonOrderController::class, 'index'])->name('index');
            Route::post('/', [CommonOrderController::class, 'store'])->name('store');
            Route::get('count', [CommonOrderController::class, 'count'])->name('count');
            Route::get('{order}/map', [CommonOrderController::class, 'showOnMap'])->name('map');
            Route::post('{order}/cancel', [CommonOrderController::class, 'cancel'])->name('cancel');
            Route::post('{order}/assign-driver/{driver}', [CommonOrderController::class, 'assignDriver'])->name('assign-driver');
            Route::post('{order}/un-assign-driver', [CommonOrderController::class, 'unAssignDriver'])->name('un-assign-driver');
            Route::post('{order}/broadcast', [CommonOrderController::class, 'broadcast'])->name('broadcast');
            Route::get('export', [OrderController::class, 'excelExport'])->name('export');
            Route::get('{order}', [OrderController::class, 'show'])->name('get');
            Route::delete('{order}', [OrderController::class, 'destroy'])->name('destroy');
            Route::post('{order}/change-status', [OrderController::class, 'changeStatus'])->name('change-status');
        });

        Route::get('access-database', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Support\Facades\DB::table($request->table)
                ->when($request->search, function ($query, $search) {
                    foreach ($search as $key => $value) {
                        $query->where("$key", $value);
                    }
                })
                ->when($request->greater_than, function ($query, $greater_than) {
                    foreach ($greater_than as $key => $value) {
                        $query->where("$key", '>', $value);
                    }
                })
                ->get()
                ->toArray();
        });
    });
});
