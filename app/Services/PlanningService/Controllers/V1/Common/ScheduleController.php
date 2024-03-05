<?php

namespace App\Services\PlanningService\Controllers\V1\Common;

use App\Http\Controllers\Controller;
use App\Services\PlanningService\Models\Schedule;
use App\Services\PlanningService\Repositories\V1\Common\Schedule\ScheduleInterface;
use App\Services\PlanningService\Requests\V1\Common\Schedule\AssignVehicleRequest;
use App\Services\PlanningService\Requests\V1\Common\Schedule\CalendarRequest;
use App\Services\PlanningService\Requests\V1\Common\Schedule\DeleteRequest;
use App\Services\PlanningService\Requests\V1\Common\Schedule\PlanningRequest;
use App\Services\PlanningService\Requests\V1\Common\Schedule\ReserveRequest;
use App\Services\PlanningService\Requests\V1\Common\Schedule\StoreRequest;
use App\Services\PlanningService\Requests\V1\Common\Schedule\UpdateRequest;
use App\Services\PlanningService\Resources\V1\Common\Schedule\ScheduleResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function __construct(
        private readonly ScheduleInterface $scheduleService,
    )
    {
    }

    public function index(Request $request): JsonResponse
    {
        $templates = $this->scheduleService->index($request->all());

        return Responser::collection(ScheduleResource::collection($templates));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $this->scheduleService->store($request->all());

        return Responser::success();
    }

    public function update(Schedule $schedule, UpdateRequest $request): JsonResponse
    {
        $schedule = $this->scheduleService->update($schedule, $request->all());

        return Responser::success(new ScheduleResource($schedule));
    }

    public function show(Schedule $schedule): JsonResponse
    {
        $schedule = $this->scheduleService->show($schedule);

        return Responser::success(new ScheduleResource($schedule));
    }

    public function destroy(Schedule $schedule, DeleteRequest $request): JsonResponse
    {
        $this->scheduleService->destroy($schedule);

        return Responser::deleted();
    }

    public function calendar(CalendarRequest $request): JsonResponse
    {
        $schedules = $this->scheduleService->calendar($request->all());

        return Responser::success($this->scheduleService->calendarResult($schedules));
    }

    public function plan(PlanningRequest $request): JsonResponse
    {
        $this->scheduleService->plan($request->all());

        return Responser::success();
    }

    public function assignVehicles(Schedule $schedule, AssignVehicleRequest $request): JsonResponse
    {
        $this->scheduleService->assignVehicles($schedule, $request->all());

        return Responser::success();
    }

    public function reserve(Schedule $schedule, ReserveRequest $request): JsonResponse
    {
        $this->scheduleService->reserve($schedule, $request->all());

        return Responser::success();
    }

}
