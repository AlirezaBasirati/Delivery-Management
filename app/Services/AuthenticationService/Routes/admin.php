<?php

use App\Services\AuthenticationService\Controllers\V1\Admin\UserController;
use App\Services\AuthenticationService\Controllers\V1\Common\AuthenticationController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api/admin/v1')->name('admin.')->group(function () {

    Route::prefix('auth')->name('auth.')->group(function () {

        Route::post('login', [AuthenticationController::class, 'login'])->name('login');
        Route::post('refresh', [AuthenticationController::class, 'refresh'])->name('refresh');

        Route::middleware('auth')->group(function () {
            Route::get('me', [AuthenticationController::class, 'me'])->name('me');
            Route::patch('me', [AuthenticationController::class, 'update'])->name('me.update');
            Route::delete('logout', [AuthenticationController::class, 'logout'])->name('logout');
            Route::patch('change-password', [AuthenticationController::class, 'changePassword'])->name('change-password');
        });
    });

    Route::apiResource('users', UserController::class);
});
