<?php

namespace App\Services\OrderService\Controllers\V2\Driver;

use App\Http\Controllers\Controller;
use App\Services\OrderService\Repository\V1\Driver\Order\OrderInterface;
use App\Services\OrderService\Resources\V2\Driver\Order\BriefOrderResource;
use App\Services\OrderService\Resources\V2\Driver\Order\OrderResource;
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

    public function current(Request $request): JsonResponse
    {
        $order = $this->orderService->current();

        return Responser::success(new OrderResource($order));
    }

}
