<?php

use App\Services\AuthorizationService\Controllers\V1\Admin\RoleController;
use App\Services\AuthorizationService\Controllers\V1\Admin\AuthorizationController;
use App\Services\AuthorizationService\Controllers\V1\Admin\PermissionController;
use App\Services\AuthorizationService\Controllers\V1\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api')->group(function () {

    Route::middleware('auth')->group(function () {
        Route::prefix('admin/v1')->name('admin.')->group(function () {

            Route::get('auth/access', [AuthorizationController::class, 'access'])->name('users.access');

            Route::apiResource('permissions', PermissionController::class);

            Route::patch('roles/{role}/permissions', [RoleController::class, 'syncPermissions'])->name('permissions.sync-permissions');
            Route::apiResource('roles', RoleController::class);

            Route::patch('users/{user}/roles', [UserController::class, 'syncRoles'])->name('users.sync-roles');
            Route::patch('users/{user}/permissions', [UserController::class, 'syncPermissions'])->name('users.sync-permissions');
            Route::patch('users/{user}/block', [UserController::class, 'block'])->name('users.block');
        });
    });
});
