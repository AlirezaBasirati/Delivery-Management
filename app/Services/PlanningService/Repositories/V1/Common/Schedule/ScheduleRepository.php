<?php

namespace App\Services\PlanningService\Repositories\V1\Common\Schedule;

use App\Services\CustomerService\Repository\V1\Common\Customer\CustomerInterface;
use App\Services\PlanningService\Enumerations\V1\WeekDay;
use App\Services\PlanningService\Models\Schedule;
use App\Services\PlanningService\Models\Template;
use App\Services\PlanningService\Repositories\V1\Common\Template\TemplateInterface;
use Carbon\Carbon;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ScheduleRepository extends BaseRepository implements ScheduleInterface
{
    public function __construct(
        Schedule                           $model,
        private readonly TemplateInterface $templateService,
        private readonly CustomerInterface $customerService)
    {
        return parent::__construct($model);
    }

    public function store(array $parameters): Model
    {
        $parameters['day_of_week'] = verta($parameters['date'])->dayOfWeek;

        return $this->model->query()->updateOrCreate([
            'tenant_id'       => $parameters['tenant_id'],
            'date'            => $parameters['date'],
            'timeslot_id'     => $parameters['timeslot_id'],
            'vehicle_type_id' => $parameters['vehicle_type_id']
        ], $parameters);
    }

    public function calendar(array $parameters): Collection|array
    {
        $from_date = $parameters['from_date'] ?? now()->format('Y-m-d H:i:s');
        $to_date = $parameters['to_date'] ?? now()->addDays(7)->format('Y-m-d H:i:s');

        return $this->model->query()
            ->whereBetween('date', [$from_date, $to_date])
            ->when($parameters['vehicle_type_id'] ?? null, function ($query, $vehicle_type_id) {
                $query->where('vehicle_type_id', $vehicle_type_id);
            })
            ->orderBy('date')
            ->get();
    }

    public function calendarResult($schedules): array
    {
        $schedules = $schedules->groupBy(['date', 'vehicle_type_id']);

        $result = [];

        foreach ($schedules as $date => $grouped_schedules_by_date) {
            foreach ($grouped_schedules_by_date as $grouped_schedules_by_type) {
                $first_schedule = $grouped_schedules_by_type->first();
                $item = [
                    'date'         => $date,
                    'vehicle_type' => $first_schedule->vehicleType?->only('id', 'title'),
                    'day_of_week'  => $first_schedule->day_of_week
                ];

                foreach ($grouped_schedules_by_type as $schedule) {
                    $item['plans'][] = [
                        'id'                => $schedule->id,
                        'timeslot'          => $schedule->timeslot->only('id', 'starts_at', 'ends_at'),
                        'capacity'          => $schedule->capacity,
                        'used_capacity'     => $schedule->used_capacity,
                        'reserved_capacity' => $schedule->reserved_capacity,
                        'vehicles_count'    => $schedule->vehicles_count,
                        'status'            => $schedule->status
                    ];
                }

                $result[] = $item;
            }
        }

        return $result;
    }

    /**
     * @throws ValidationException
     */
    public function plan(array $parameters): void
    {
        $from_date = Carbon::parse(($parameters['from_date']));
        $to_date = Carbon::parse(($parameters['to_date']));
        $date = $from_date->copy();

        $invalid_query = $this->model->query()
            ->whereDate('date', '>=', $from_date)
            ->where('tenant_id', $parameters['tenant_id'])
            ->where('vehicle_type_id', $parameters['vehicle_type_id'])
            ->where(function ($query) {
                $query->where('reserved_capacity', '>', 0)
                    ->orWhere('used_capacity', '>', 0);
            });

        if ($invalid_query->exists()) {
            throw ValidationException::withMessages([
                'from_date' => __('messages.possible_to_plan_from_date', ['attribute' => $invalid_query->max('date')])
            ]);
        }

        /** @var Template $template */
        $template = $this->templateService->find($parameters['template_id']);
        $template_items = $template->items;

        $first_week_day = WeekDay::from(verta($parameters['from_date'])->dayOfWeek);
        $week_day = $first_week_day;

        do {
            $timeslots = $template_items->where('day_of_week', $week_day->value);

            do {
                foreach ($timeslots as $timeslot) {
                    $this->model->query()->updateOrCreate([
                        'tenant_id'       => $parameters['tenant_id'],
                        'date'            => $date->format('Y-m-d'),
                        'timeslot_id'     => $timeslot->timeslot_id,
                        'vehicle_type_id' => $parameters['vehicle_type_id'],
                        'day_of_week'     => $week_day->value
                    ], [
                        'capacity' => $timeslot->capacity,
                    ]);
                }

                $date = $date->addDays(7);

            } while ($date < $to_date);

            $week_day = WeekDay::nextDay($week_day);
            $date = $from_date->addDay()->copy();

        } while ($week_day != $first_week_day);
    }

    public function assignVehicles(Schedule $schedule, array $parameters): void
    {
        $schedule->vehicles()->syncWithoutDetaching($parameters['vehicle_ids']);
    }

    /**
     * @throws ValidationException
     */
    public function reserve(Schedule $schedule, array $parameters): void
    {
        DB::beginTransaction();

        $customer = $this->customerService->firstOrCreate($parameters);

        $customer_reserves = $schedule->customerReserves();

        if (!$customer_reserves->clone()->count()) {
            $updated = $this->model->query()
                ->where('id', $schedule->id)
                ->whereRaw('used_capacity + reserved_capacity < capacity')
                ->lockForUpdate()
                ->update([
                    'reserved_capacity' => DB::raw('reserved_capacity + 1')
                ]);

            if (!$updated) {
                throw ValidationException::withMessages(['schedule' => __('messages.completed_capacity')]);
            }

            $customer_reserves->attach($customer);
        }
        else {
            throw ValidationException::withMessages(['schedule' => __('messages.capacity_has_been_reserved')]);
        }

        DB::commit();
    }
}
