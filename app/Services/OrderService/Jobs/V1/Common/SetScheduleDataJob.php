<?php

namespace App\Services\OrderService\Jobs\V1\Common;

use App\Services\OrderService\Models\Order;
use App\Services\PlanningService\Models\Schedule;
use App\Services\PlanningService\Repositories\V1\Common\Schedule\ScheduleInterface;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SetScheduleDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly Order $order)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(ScheduleInterface $scheduleService): void
    {

        /** @var Schedule $schedule */
        $schedule = $scheduleService->find($this->order->schedule_id);

        $start_of_schedule = Carbon::parse($schedule->date);
        $time = explode(':', $schedule->timeslot->starts_at);
        $start_of_schedule->setTime($time[0], $time[1], $time[2]);

        $this->order->start_of_schedule = $start_of_schedule;
        $this->order->save();
    }
}
