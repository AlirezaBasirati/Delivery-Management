<?php

namespace App\Services\FleetService\Controllers\V1\Common;

use App\Http\Controllers\Controller;
use App\Services\FleetService\Repository\V1\Common\VehicleType\VehicleTypeInterface;
use App\Services\FleetService\Resources\V1\Common\VehicleType\VehicleTypeResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    public function __construct(
        private readonly VehicleTypeInterface $vehicleTypeService,
    )
    {
    }

    public function index(Request $request): JsonResponse
    {
        $vehicles = $this->vehicleTypeService->index($request->all(), ['vehicle_types.*']);

        return Responser::collection(VehicleTypeResource::collection($vehicles));
    }
}
