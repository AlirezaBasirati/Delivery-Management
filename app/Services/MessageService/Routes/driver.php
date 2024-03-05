<?php

use App\Services\MessageService\Controllers\V1\Common\TicketController;
use App\Services\MessageService\Controllers\V1\Common\TicketMessageController;
use App\Services\MessageService\Controllers\V1\Driver\StaticMessageController;
use App\Services\MessageService\Controllers\V1\Driver\StaticMessageGroupController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth:api'])->prefix('api/driver/v1')->name('driver.')->group(function () {

    Route::get('static-messages', [StaticMessageController::class, 'index'])->name('static-messages.get');
    Route::get('static-message-groups', [StaticMessageGroupController::class, 'index'])->name('static-message-groups.get');

    Route::get('tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('tickets', [TicketController::class, 'store'])->name('tickets.store');

    Route::get('tickets/{ticket}/messages', [TicketMessageController::class, 'messages'])->name('ticket-messages');
    Route::post('ticket-messages', [TicketMessageController::class, 'store'])->name('ticket-store-message');
});

