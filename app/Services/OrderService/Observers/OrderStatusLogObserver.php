<?php

namespace App\Services\OrderService\Observers;

use App\Services\OrderService\Enumerations\V1\TenantWebhookCallType;
use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Events\V1\NoDriverFoundEvent;
use App\Services\OrderService\Events\V1\OrderAssignedEvent;
use App\Services\OrderService\Events\V1\OrderDoneEvent;
use App\Services\OrderService\Events\V1\OrderPickedUpEvent;
use App\Services\OrderService\Events\V1\OrderUnAssignedEvent;
use App\Services\OrderService\Models\OrderStatusLog;
use Illuminate\Support\Facades\DB;
use Spatie\WebhookServer\WebhookCall;

class OrderStatusLogObserver
{
    public function __construct()
    {
    }

    /**
     * Handle the OrderStatusLog "created" event.
     */
    public function created(OrderStatusLog $orderStatusLog): void
    {
        DB::beginTransaction();

        $order = $orderStatusLog->order;

        if ($orderStatusLog->order_status_id != OrderStatus::NEED_SUPPORT->value) {
            $order->last_status_id = $orderStatusLog->order_status_id;
            $order->save();
        }

//        if ($orderStatusLog->order_status_id == OrderStatus::PENDING->value) {
//            dispatch(new FindDriversJob($order));
//        }
        if ($orderStatusLog->order_status_id == OrderStatus::ASSIGNED->value) {
            OrderAssignedEvent::dispatch($order);
        }
        elseif ($orderStatusLog->order_status_id == OrderStatus::PICKED_UP->value) {
            OrderPickedUpEvent::dispatch($order);
        }
        elseif ($orderStatusLog->order_status_id == OrderStatus::DONE->value) {
            OrderDoneEvent::dispatch($order);
        }
        elseif ($orderStatusLog->order_status_id == OrderStatus::NO_DRIVER_FOUND->value) {
            NoDriverFoundEvent::dispatch($order);
        }
        elseif (in_array($orderStatusLog->order_status_id, [
            OrderStatus::UNASSIGNED_BEFORE_PICKED_UP->value,
            OrderStatus::UNASSIGNED_AFTER_PICKED_UP->value
        ])) {
            OrderUnAssignedEvent::dispatch($order, $orderStatusLog->id, request()->static_message_id ?? null);
        }

        $call_webhook = !in_array($orderStatusLog->order_status_id, [
            OrderStatus::NEED_SUPPORT->value,
            OrderStatus::PARTIAL_RETURN->value,
            OrderStatus::ABSENCE_OF_RECEIVER->value,
            OrderStatus::COMPLETE_RETURN->value,
            OrderStatus::CUSTOMER_CANCELED->value
        ]);

        if ($call_webhook) {
            WebhookCall::create()
                ->url($order->tenant->webhook_url)
                ->payload([
                    'type'    => TenantWebhookCallType::CHANGE_ORDER_STATUS->value,
                    'payload' => [
                        'id'     => $order->id,
                        'code'   => $order->code,
                        'status' => $order->lastStatus?->name
                    ]
                ])
                ->useSecret(env('ZOOT_WEBHOOK_SECRET'))
                ->dispatch();
        }

        DB::commit();
    }
}
