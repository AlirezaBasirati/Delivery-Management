<?php

namespace App\Services\PlanningService\Requests\V1\Common\Schedule;

use App\Services\AuthenticationService\Models\User;
use App\Services\FleetService\Models\Vehicle;
use App\Services\PlanningService\Models\Schedule;
use Illuminate\Foundation\Http\FormRequest;

class AssignVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Schedule $schedule */
        $schedule = $this->route('schedule');

        return $schedule->tenant_id == auth()->user()->tenant_id;
    }

    public function rules(): array
    {
        return [
            'vehicle_ids'   => ['required', 'array'],
            'vehicle_ids.*' => ['required', 'exists:vehicles,id']
        ];
    }
}
