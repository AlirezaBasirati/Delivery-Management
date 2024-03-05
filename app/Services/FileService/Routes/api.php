<?php

use App\Services\FileService\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api')->group(function () {
    Route::post('admin/v1/files', [FileController::class, 'store'])->name('admin.files.upload');
});
