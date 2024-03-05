<?php

namespace App\Services\OrderService\Controllers\V1\Tenant;

use App\Http\Controllers\Controller;
use App\Services\OrderService\Repository\V1\Tenant\OrderStatusLog\OrderStatusLogInterface;
use App\Services\OrderService\Requests\V1\Tenant\OrderStatusLog\IndexRequest;
use App\Services\OrderService\Resources\V1\Tenant\OrderStatusLog\OrderStatusLogResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;

class OrderStatusLogController extends Controller
{
    public function __construct(
        private readonly OrderStatusLogInterface $orderStatusLogService,
    )
    {
    }

    public function index(IndexRequest $request): JsonResponse
    {
        $drivers = $this->orderStatusLogService->index($request->all());

        return Responser::collection(OrderStatusLogResource::collection($drivers));
    }
}
