<?php

namespace App\Services\FleetService\Controllers\V1\Driver;

use App\Http\Controllers\Controller;
use App\Services\FleetService\Repository\V1\Driver\Driver\DriverInterface;
use App\Services\FleetService\Requests\V1\Driver\Driver\ActivationRequest;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;

class DriverController extends Controller
{
    public function __construct(
        private readonly DriverInterface $driverService,
    )
    {
    }

    public function activation(ActivationRequest $request): JsonResponse
    {
        $this->driverService->activation($request->user(), $request->all());

        return Responser::success();
    }

}
