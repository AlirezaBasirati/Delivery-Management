<?php

use App\Services\CacheService\Controllers\V1\Common\CacheController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth:api'])->prefix('api/dispatcher/v1')->name('dispatcher.')->group(function () {
    Route::get('cache/{key}', [CacheController::class, 'get'])->name('cache.get');
});

