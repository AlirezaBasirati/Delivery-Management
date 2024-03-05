<?php

namespace App\Services\OrderService\Controllers\V1\Common;

use App\Http\Controllers\Controller;
use App\Services\FleetService\Models\Driver;
use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Repository\V1\Common\Order\OrderInterface;
use App\Services\OrderService\Repository\V1\Common\OrderLocation\OrderLocationInterface;
use App\Services\OrderService\Requests\V1\Common\Order\AddNewDropOffToOrderRequest;
use App\Services\OrderService\Requests\V1\Common\Order\AssignDriverRequest;
use App\Services\OrderService\Requests\V1\Common\Order\BroadcastRequest;
use App\Services\OrderService\Requests\V1\Common\Order\BulkAssignDriverRequest;
use App\Services\OrderService\Requests\V1\Common\Order\BulkDispatchRequest;
use App\Services\OrderService\Requests\V1\Common\Order\CancelRequest;
use App\Services\OrderService\Requests\V1\Common\Order\IndexRequest;
use App\Services\OrderService\Requests\V1\Common\Order\ShowOnMapRequest;
use App\Services\OrderService\Requests\V1\Common\Order\StoreRequest;
use App\Services\OrderService\Requests\V1\Common\Order\UnAssignDriverRequest;
use App\Services\OrderService\Resources\V1\Common\Order\BriefOrderResource;
use App\Services\OrderService\Resources\V1\Common\Order\OrderCountResource;
use App\Services\OrderService\Resources\V1\Common\Order\OrderResource;
use App\Services\OrderService\Resources\V1\Common\Order\ShowOrderOnMapResource;
use App\Services\OrderService\Resources\V1\Common\Order\StoreOrderResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderInterface $orderService,
        private readonly OrderLocationInterface $locationService
    )
    {
    }

    public function index(IndexRequest $request): JsonResponse
    {
        $orders = $this->orderService->index($request->all(), $request->columns ?? ['*']);

        return Responser::collection(BriefOrderResource::collection($orders));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $order = $this->orderService->store($request->all());

        return Responser::success(new StoreOrderResource($order));
    }

    public function show(Order $order, Request $request): JsonResponse
    {
        $order = $this->orderService->show($order);

        return Responser::success(new OrderResource($order));
    }

    public function cancel(Order $order, CancelRequest $request): JsonResponse
    {
        $this->orderService->cancel($order);

        return Responser::success();
    }

    public function assignDriver(Order $order, Driver $driver, AssignDriverRequest $request): JsonResponse
    {
        $order = $this->orderService->assignDriver($order, $driver, $request->validated());

        return Responser::success();
    }

    public function unAssignDriver(Order $order, UnAssignDriverRequest $request): JsonResponse
    {
        $order = $this->orderService->unAssignDriver($order, $request->validated());

        return Responser::success();
    }

    public function broadcast(Order $order, BroadcastRequest $request): JsonResponse
    {
        $this->orderService->broadcast($order, $request->validated());

        return Responser::success();
    }

    public function showOnMap(Order $order, ShowOnMapRequest $request): JsonResponse
    {
        return Responser::success(new ShowOrderOnMapResource($order));
    }

    public function count(): JsonResponse
    {
        $orders_count = $this->orderService->count();

        return Responser::success(OrderCountResource::collection($orders_count));
    }

    public function bulkAssignDriver(BulkAssignDriverRequest $request): JsonResponse
    {
        $this->orderService->bulkAssignDriver($request->validated());

        return Responser::success();
    }

    public function bulkDispatch(BulkDispatchRequest $request): JsonResponse
    {
        $this->orderService->bulkDispatch($request->validated());

        return Responser::success();
    }

    public function addDropOffToOrder(Order $order, AddNewDropOffToOrderRequest $request): JsonResponse
    {
        $this->locationService->addDropOffToOrder($order, $request->validated());

        return Responser::success();
    }

}
