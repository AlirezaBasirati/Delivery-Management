<?php

use App\Services\CustomerService\Controllers\V1\Customer\BookmarkController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth:api'])->prefix('api/customer/v1')->name('customer.')->group(function () {
    Route::apiResource('/bookmarks', BookmarkController::class);
});
