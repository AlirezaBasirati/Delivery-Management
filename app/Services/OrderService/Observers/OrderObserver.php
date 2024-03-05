<?php

namespace App\Services\OrderService\Observers;

use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Repository\V1\Common\OrderStatusLog\OrderStatusLogInterface;

class OrderObserver
{
    public function __construct(private readonly OrderStatusLogInterface $orderStatusLog)
    {
    }

    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = true;

    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        $this->orderStatusLog->store(['order_id' => $order->id, 'order_status_id' => OrderStatus::PENDING->value]);

        if (!$order->code) {
            $order->code = $order->delivery_code;
            $order->save();
        }
    }
}
