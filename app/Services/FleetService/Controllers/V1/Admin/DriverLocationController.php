<?php

namespace App\Services\FleetService\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Services\FleetService\Repository\V1\Admin\DriverLocation\DriverLocationInterface;
use App\Services\FleetService\Requests\V1\Admin\DriverLocation\IndexRequest;
use App\Services\FleetService\Resources\V1\Admin\DriverLocation\DriverLocationResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DriverLocationController extends Controller
{
    public function __construct(
        private readonly DriverLocationInterface $driverLocationService,
    )
    {
    }

    public function index(IndexRequest $request): JsonResponse
    {
        $vehicles = $this->driverLocationService->index($request->all(), ['driver_locations.*']);

        return Responser::collection(DriverLocationResource::collection($vehicles));
    }
}
