<?php

namespace App\Services\OrderService\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Services\OrderService\Models\OrderStatus;
use App\Services\OrderService\Repository\V1\Admin\OrderStatus\OrderStatusInterface;
use App\Services\OrderService\Requests\V1\Admin\OrderStatus\StoreRequest;
use App\Services\OrderService\Requests\V1\Admin\OrderStatus\UpdateRequest;
use App\Services\OrderService\Resources\V1\Common\OrderStatus\OrderStatusResource;
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

    public function index(Request $request): JsonResponse
    {
        $drivers = $this->orderStatusService->index($request->all());

        return Responser::collection(OrderStatusResource::collection($drivers));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $driver = $this->orderStatusService->store($request->all());

        return Responser::created(new OrderStatusResource($driver));
    }

    public function update(UpdateRequest $request, OrderStatus $orderStatus): JsonResponse
    {
        $orderStatus = $this->orderStatusService->update($orderStatus, $request->all());

        return Responser::success(new OrderStatusResource($orderStatus));
    }

    public function show(OrderStatus $orderStatus): JsonResponse
    {
        $orderStatus = $this->orderStatusService->show($orderStatus);

        return Responser::success(new OrderStatusResource($orderStatus));
    }

    public function destroy(OrderStatus $orderStatus): JsonResponse
    {
        if ($orderStatus->reserve) {
            return Responser::forbidden([], [__('messages.can_not_delete_reserved_status')]);
        }

        $this->orderStatusService->destroy($orderStatus);

        return Responser::deleted();
    }
}
