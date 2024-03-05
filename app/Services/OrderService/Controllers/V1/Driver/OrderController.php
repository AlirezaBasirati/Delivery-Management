<?php

namespace App\Services\OrderService\Controllers\V1\Driver;

use App\Http\Controllers\Controller;
use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Repository\V1\Driver\Order\OrderInterface;
use App\Services\OrderService\Requests\V1\Driver\Order\ChangeStatusRequest;
use App\Services\OrderService\Requests\V1\Driver\Order\AcceptRequest;
use App\Services\OrderService\Requests\V1\Driver\Order\ReturnRequest;
use App\Services\OrderService\Requests\V1\Driver\Order\SelectRequest;
use App\Services\OrderService\Requests\V1\Driver\Order\SetLocationsRequest;
use App\Services\OrderService\Requests\V1\Driver\Order\UnAssignRequest;
use App\Services\OrderService\Resources\V1\Common\OrderItem\OrderItemResource;
use App\Services\OrderService\Resources\V1\Driver\Order\BriefOrderResource;
use App\Services\OrderService\Resources\V1\Driver\Order\OrderResource;
use App\Services\OrderService\Resources\V1\Driver\Order\ScheduledOrderResource;
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

    public function scheduledList(Request $request): JsonResponse
    {
        $orders = $this->orderService->scheduledList();

        return Responser::success(ScheduledOrderResource::collection($orders));
    }

    public function items(Request $request): JsonResponse
    {
        $items = $this->orderService->items();

        return Responser::success(new OrderItemResource($items));
    }

    public function accept(AcceptRequest $request): JsonResponse
    {
        $order = $this->orderService->accept($request->validated());

        if ($order) {
            return Responser::success();
        }

        return Responser::forbidden([], [__('messages.no_order_for_driver')]);
    }

    public function changeStatus(ChangeStatusRequest $request): JsonResponse
    {
        $this->orderService->changeStatus($request->all());

        return Responser::success();
    }

    public function select(Order $order, SelectRequest $request): JsonResponse
    {
        $this->orderService->select($order);

        return Responser::success();
    }

    public function unAssign(UnAssignRequest $request): JsonResponse
    {
        $this->orderService->unAssign($request->all());

        return Responser::success();
    }

    public function return(ReturnRequest $request): JsonResponse
    {
        $this->orderService->return($request->all());

        return Responser::success();
    }

    public function storeNeedSupportLog(): JsonResponse
    {
        $this->orderService->storeNeedSupportLog();

        return Responser::success();
    }

    public function reorderLocations(SetLocationsRequest $request): JsonResponse
    {
        $this->orderService->reorderLocations($request->validated());

        return Responser::success();
    }

}
