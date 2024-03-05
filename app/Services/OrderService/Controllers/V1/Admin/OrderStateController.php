<?php

namespace App\Services\OrderService\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Services\OrderService\Models\OrderState;
use App\Services\OrderService\Repository\V1\Admin\OrderState\OrderStateInterface;
use App\Services\OrderService\Requests\V1\Admin\OrderState\StoreRequest;
use App\Services\OrderService\Requests\V1\Admin\OrderState\UpdateRequest;
use App\Services\OrderService\Resources\V1\Common\OrderState\OrderStateResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderStateController extends Controller
{
    public function __construct(
        private readonly OrderStateInterface $orderStateService,
    )
    {
    }

    public function index(Request $request): JsonResponse
    {
        $drivers = $this->orderStateService->index($request->all());

        return Responser::collection(OrderStateResource::collection($drivers));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $driver = $this->orderStateService->store($request->all());

        return Responser::created(new OrderStateResource($driver));
    }

    public function update(UpdateRequest $request, OrderState $orderState): JsonResponse
    {
        $orderState = $this->orderStateService->update($orderState, $request->all());

        return Responser::success(new OrderStateResource($orderState));
    }

    public function show(OrderState $orderState): JsonResponse
    {
        $orderState = $this->orderStateService->show($orderState);

        return Responser::success(new OrderStateResource($orderState));
    }

    public function destroy(OrderState $orderState): JsonResponse
    {
        $this->orderStateService->destroy($orderState);

        return Responser::deleted();
    }
}
