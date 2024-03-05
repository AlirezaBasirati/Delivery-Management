<?php

use App\Services\AuthenticationService\Controllers\V1\Common\AuthenticationController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api/customer/v1')->name('customer.')->group(function () {
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('check', [AuthenticationController::class, 'check'])->name('check');
        Route::post('verify', [AuthenticationController::class, 'verify'])->name('verify');
        Route::post('forget', [AuthenticationController::class, 'forget'])->name('forget');
        Route::post('reset', [AuthenticationController::class, 'reset'])->name('reset');
        Route::post('set-password', [AuthenticationController::class, 'setPassword'])->name('set-password');

        Route::put('/', [AuthenticationController::class, 'store'])->name('store');

        Route::middleware('auth')->group(function () {
            Route::get('me', [AuthenticationController::class, 'me'])->name('me.get');
            Route::patch('me', [AuthenticationController::class, 'update'])->name('me.update');
            Route::delete('logout', [AuthenticationController::class, 'logout'])->name('logout');
            Route::patch('change-password', [AuthenticationController::class, 'changePassword'])->name('change-password');
        });

    });
});
