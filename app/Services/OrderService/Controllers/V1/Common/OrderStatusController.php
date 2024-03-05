<?php

namespace App\Services\OrderService\Controllers\V1\Common;

use App\Http\Controllers\Controller;
use App\Services\OrderService\Repository\V1\Common\OrderStatus\OrderStatusInterface;
use App\Services\OrderService\Resources\V1\Common\OrderStatus\OrdersCountResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    public function __construct(
        private readonly OrderStatusInterface $orderStatusService,
    )
    {
    }

    public function ordersCount(Request $request): JsonResponse
    {
        $order_statuses = $this->orderStatusService->ordersCount();

        return Responser::collection(OrdersCountResource::collection($order_statuses));
    }
}
