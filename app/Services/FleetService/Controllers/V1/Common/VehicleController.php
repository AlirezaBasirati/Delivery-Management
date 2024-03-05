<?php

namespace App\Services\FleetService\Controllers\V1\Common;

use App\Http\Controllers\Controller;
use App\Services\FleetService\Models\Driver;
use App\Services\FleetService\Models\Vehicle;
use App\Services\FleetService\Repository\V1\Common\Vehicle\VehicleInterface;
use App\Services\FleetService\Requests\V1\Common\Vehicle\AssignDriverRequest;
use App\Services\FleetService\Requests\V1\Common\Vehicle\AssignSchedulesRequest;
use App\Services\FleetService\Requests\V1\Common\Vehicle\DeleteRequest;
use App\Services\FleetService\Requests\V1\Common\Vehicle\StoreRequest;
use App\Services\FleetService\Requests\V1\Common\Vehicle\UnAssignDriverRequest;
use App\Services\FleetService\Requests\V1\Common\Vehicle\UpdateRequest;
use App\Services\FleetService\Resources\V1\Common\Vehicle\BriefVehicleResource;
use App\Services\FleetService\Resources\V1\Common\Vehicle\SelectVehicleResource;
use App\Services\FleetService\Resources\V1\Common\Vehicle\VehicleResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function __construct(
        private readonly VehicleInterface $vehicleService,
    )
    {
    }

    public function index(Request $request): JsonResponse
    {
        $vehicles = $this->vehicleService->index($request->all());

        return Responser::collection(BriefVehicleResource::collection($vehicles));
    }

    public function select(Request $request): JsonResponse
    {
        $vehicles = $this->vehicleService->index($request->all());

        return Responser::collection(SelectVehicleResource::collection($vehicles));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $vehicle = $this->vehicleService->store($request->all());

        return Responser::created(new VehicleResource($vehicle));
    }

    public function update(UpdateRequest $request, Vehicle $vehicle): JsonResponse
    {
        $vehicle = $this->vehicleService->update($vehicle, $request->all());

        return Responser::success(new VehicleResource($vehicle));
    }

    public function show(Vehicle $vehicle): JsonResponse
    {
        $vehicle = $this->vehicleService->show($vehicle);

        return Responser::success(new VehicleResource($vehicle));
    }

    public function destroy(Vehicle $vehicle, DeleteRequest $request): JsonResponse
    {
        $this->vehicleService->destroy($vehicle);

        return Responser::deleted();
    }

    public function assignDriver(Vehicle $vehicle, Driver $driver, AssignDriverRequest $request): JsonResponse
    {
        $this->vehicleService->assignDriver($vehicle, $driver, $request->all());

        return Responser::success();
    }

    public function unAssignDriver(Vehicle $vehicle, Driver $driver, UnAssignDriverRequest $request): JsonResponse
    {
        $this->vehicleService->unAssignDriver($vehicle, $driver);

        return Responser::success();
    }

    public function assignSchedules(Vehicle $vehicle, AssignSchedulesRequest $request): JsonResponse
    {
        $this->vehicleService->assignSchedules($vehicle, $request->all());

        return Responser::success();
    }
}
