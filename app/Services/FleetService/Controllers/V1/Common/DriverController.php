<?php

namespace App\Services\FleetService\Controllers\V1\Common;

use App\Http\Controllers\Controller;
use App\Services\FleetService\Models\Driver;
use App\Services\FleetService\Models\Vehicle;
use App\Services\FleetService\Repository\V1\Common\Driver\DriverInterface;
use App\Services\FleetService\Requests\V1\Common\Driver\AssignVehicleRequest;
use App\Services\FleetService\Requests\V1\Common\Driver\CountRequest;
use App\Services\FleetService\Requests\V1\Common\Driver\DeleteRequest;
use App\Services\FleetService\Requests\V1\Common\Driver\StoreRequest;
use App\Services\FleetService\Requests\V1\Common\Driver\UnAssignVehicleRequest;
use App\Services\FleetService\Requests\V1\Common\Driver\UpdateRequest;
use App\Services\FleetService\Resources\V1\Common\Driver\DriverResource;
use App\Services\FleetService\Resources\V1\Common\Driver\IndexDriverResource;
use App\Services\FleetService\Resources\V1\Common\Driver\MapResource;
use App\Services\FleetService\Resources\V1\Common\Driver\SelectDriverResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function __construct(
        private readonly DriverInterface $driverService,
    )
    {
    }

    public function index(Request $request): JsonResponse
    {
        $drivers = $this->driverService->index($request->all());

        return Responser::collection(IndexDriverResource::collection($drivers));
    }

    public function select(Request $request): JsonResponse
    {
        $drivers = $this->driverService->index($request->all());

        return Responser::collection(SelectDriverResource::collection($drivers));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $driver = $this->driverService->store($request->all());

        return Responser::created(new DriverResource($driver));
    }

    public function update(UpdateRequest $request, Driver $driver): JsonResponse
    {
        $driver = $this->driverService->update($driver, $request->all());

        return Responser::success(new DriverResource($driver));
    }

    public function show(Driver $driver): JsonResponse
    {
        $driver = $this->driverService->show($driver);

        return Responser::success(new DriverResource($driver));
    }

    public function destroy(Driver $driver, DeleteRequest $request): JsonResponse
    {
        $this->driverService->destroy($driver);

        return Responser::deleted();
    }

    public function assignVehicle(Driver $driver, Vehicle $vehicle, AssignVehicleRequest $request): JsonResponse
    {
        $this->driverService->assignVehicle($driver, $vehicle, $request->all());

        return Responser::success();
    }

    public function unAssignVehicle(Driver $driver, Vehicle $vehicle, UnAssignVehicleRequest $request): JsonResponse
    {
        $this->driverService->unAssignVehicle($driver, $vehicle);

        return Responser::success();
    }

    public function map(Request $request): JsonResponse
    {
        $locations = $this->driverService->map($request->all());

        return Responser::collection(MapResource::collection($locations));
    }

    public function count(CountRequest $request): JsonResponse
    {
        $count = $this->driverService->count($request->all());

        return Responser::success($count->toArray());
    }
}
