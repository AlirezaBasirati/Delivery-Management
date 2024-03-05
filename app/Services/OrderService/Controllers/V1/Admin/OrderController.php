<?php

namespace App\Services\OrderService\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Services\OrderService\Exports\V1\OrdersExport;
use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Repository\V1\Admin\Order\OrderInterface;
use App\Services\OrderService\Repository\V1\Common\OrderStatusLog\OrderStatusLogInterface;
use App\Services\OrderService\Requests\V1\Admin\Order\ChangeStatusRequest;
use App\Services\OrderService\Requests\V1\Common\Order\IndexRequest;
use App\Services\OrderService\Resources\V1\Common\Order\BriefOrderResource;
use App\Services\OrderService\Resources\V1\Common\Order\OrderResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderInterface $orderService,
        private readonly OrderStatusLogInterface $orderStatusLogService,
    )
    {
    }

    public function show(Order $order): JsonResponse
    {
        $order = $this->orderService->show($order);

        return Responser::success(new OrderResource($order));
    }

    public function destroy(Order $order): JsonResponse
    {
        $this->orderService->destroy($order);

        return Responser::deleted();
    }

    public function excelExport(IndexRequest $request): BinaryFileResponse
    {
        $parameters = $request->all();
        $parameters['paginate'] = false;

        $orders = $this->orderService->index($parameters, $request->columns ?? ['orders.*']);

        return Excel::download(new OrdersExport($orders), 'orders-report.xls', \Maatwebsite\Excel\Excel::XLS);
    }

    public function changeStatus(Order $order, ChangeStatusRequest $request): JsonResponse
    {
        $this->orderStatusLogService->store(['order_id' => $order->id, 'order_status_id' => $request->status_id]);

        return Responser::created(new BriefOrderResource($order->refresh()));
    }

}
