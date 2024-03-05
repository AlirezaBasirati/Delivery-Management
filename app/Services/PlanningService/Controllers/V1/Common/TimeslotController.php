<?php

namespace App\Services\PlanningService\Controllers\V1\Common;

use App\Http\Controllers\Controller;
use App\Services\PlanningService\Models\Timeslot;
use App\Services\PlanningService\Repositories\V1\Common\Timeslot\TimeslotInterface;
use App\Services\PlanningService\Requests\V1\Common\Timeslot\StoreRequest;
use App\Services\PlanningService\Requests\V1\Common\Timeslot\UpdateRequest;
use App\Services\PlanningService\Requests\V1\Common\Timeslot\DeleteRequest;
use App\Services\PlanningService\Resources\V1\Common\Timeslot\IndexTimeslotResource;
use App\Services\PlanningService\Resources\V1\Common\Timeslot\SelectTimeslotResource;
use App\Services\PlanningService\Resources\V1\Common\Timeslot\TimeslotResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TimeslotController extends Controller
{
    public function __construct(
        private readonly TimeslotInterface $timeslotService,
    )
    {
    }

    public function index(Request $request): JsonResponse
    {
        $timeslots = $this->timeslotService->index($request->all());

        return Responser::collection(IndexTimeslotResource::collection($timeslots));
    }

    public function select(Request $request): JsonResponse
    {
        $timeslots = $this->timeslotService->index($request->all());

        return Responser::collection(SelectTimeslotResource::collection($timeslots));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $this->timeslotService->store($request->all());

        return Responser::success();
    }

    public function update(Timeslot $timeslot, UpdateRequest $request): JsonResponse
    {
        $timeslot = $this->timeslotService->update($timeslot, $request->all());

        return Responser::success(new TimeslotResource($timeslot));
    }

    public function show(Timeslot $timeslot): JsonResponse
    {
        $timeslot = $this->timeslotService->show($timeslot);

        return Responser::success(new TimeslotResource($timeslot));
    }

    public function destroy(Timeslot $timeslot, DeleteRequest $request): JsonResponse
    {
        $this->timeslotService->destroy($timeslot);

        return Responser::deleted();
    }
}
