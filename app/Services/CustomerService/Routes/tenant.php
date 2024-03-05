<?php

use App\Services\CustomerService\Controllers\V1\Common\CustomerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth:api'])->prefix('api/tenant/v1')->name('tenant.')->group(function () {
    Route::get('/customers/export', [CustomerController::class, 'export'])->name('customer-export');
    Route::apiResource('/customers', CustomerController::class);
});
