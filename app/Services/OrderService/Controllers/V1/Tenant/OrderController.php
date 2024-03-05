<?php

namespace App\Services\OrderService\Controllers\V1\Tenant;

use App\Http\Controllers\Controller;
use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Repository\V1\Common\Order\OrderInterface;
use App\Services\OrderService\Requests\V1\Tenant\Order\CancelRequest;
use App\Services\OrderService\Resources\V1\Tenant\Order\OrderResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderInterface $orderService,
    )
    {
    }

    public function cancel(CancelRequest $request): JsonResponse
    {
        $this->orderService->cancel($request->order, OrderStatus::CUSTOMER_CANCELED->value);

        return Responser::success();
    }

    public function show(Request $request, Order $order): JsonResponse
    {
        $order = $this->orderService->show($order);

        return Responser::success(new OrderResource($order));
    }

}
