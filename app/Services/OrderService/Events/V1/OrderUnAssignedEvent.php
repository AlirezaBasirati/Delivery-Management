<?php

namespace App\Services\OrderService\Events\V1;

use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Models\Order;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderUnAssignedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Order $order, public int $order_status_log_id, public ?int $static_message_id
    ) {}
}
