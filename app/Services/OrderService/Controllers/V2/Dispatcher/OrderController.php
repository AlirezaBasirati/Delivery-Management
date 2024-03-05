<?php

namespace App\Services\OrderService\Controllers\V2\Dispatcher;

use App\Http\Controllers\Controller;
use App\Services\OrderService\Repository\V1\Common\Order\OrderInterface;
use App\Services\OrderService\Requests\V1\Common\Order\IndexRequest;
use App\Services\OrderService\Resources\V2\Dispatcher\Order\BriefOrderResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderInterface $orderService,
    )
    {
    }

    public function index(IndexRequest $request): JsonResponse
    {
        $orders = $this->orderService->index($request->all(), $request->columns ?? ['*']);

        return Responser::collection(BriefOrderResource::collection($orders));
    }
}
