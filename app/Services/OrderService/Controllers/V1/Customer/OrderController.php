<?php

namespace App\Services\OrderService\Controllers\V1\Customer;

use App\Http\Controllers\Controller;
use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Repository\V1\Customer\Order\OrderInterface;
use App\Services\OrderService\Requests\V1\Customer\HurryRequest;
use App\Services\OrderService\Resources\V1\Customer\Order\BriefOrderResource;
use App\Services\OrderService\Resources\V1\Customer\Order\OrderResource;
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

    public function index(Request $request): JsonResponse
    {
        $orders = $this->orderService->index($request->all());

        return Responser::collection(BriefOrderResource::collection($orders));
    }

    public function show(Order $order): JsonResponse
    {
        $order = $this->orderService->show($order);

        return Responser::success(new OrderResource($order));
    }

    public function currents(): JsonResponse
    {
        $order = $this->orderService->currents();

        return Responser::success(OrderResource::collection($order));
    }

    public function hurry(HurryRequest $request, Order $order): JsonResponse
    {
        $this->orderService->hurry($order);

        return Responser::success();
    }
}
