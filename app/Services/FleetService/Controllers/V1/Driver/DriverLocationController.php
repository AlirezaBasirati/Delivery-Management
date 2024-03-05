<?php

namespace App\Services\FleetService\Controllers\V1\Driver;

use App\Http\Controllers\Controller;
use App\Services\FleetService\Repository\V1\Driver\DriverLocation\DriverLocationInterface;
use App\Services\FleetService\Requests\V1\Driver\DriverLocation\StoreRequest;
use App\Services\FleetService\Resources\V1\Driver\DriverLocation\DriverLocationResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;

class DriverLocationController extends Controller
{
    public function __construct(
        private readonly DriverLocationInterface $driverLocationService,
    )
    {
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $vehicle = $this->driverLocationService->store($request->all());

        return Responser::created(new DriverLocationResource($vehicle));
    }
}
