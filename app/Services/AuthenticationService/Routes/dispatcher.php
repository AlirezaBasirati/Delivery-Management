<?php

use App\Services\AuthenticationService\Controllers\V1\Common\AuthenticationController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api/dispatcher/v1/auth')->name('dispatcher.auth.')->group(function () {
    Route::post('login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('refresh', [AuthenticationController::class, 'refresh'])->name('refresh');

    Route::middleware('auth')->group(function () {
        Route::get('me', [AuthenticationController::class, 'me'])->name('me');
        Route::patch('me', [AuthenticationController::class, 'update'])->name('me.update');
        Route::delete('logout', [AuthenticationController::class, 'logout'])->name('logout');
    });
});
