<?php

namespace App\Services\PlanningService\Requests\V1\Common\Timeslot;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->tenant_id == $this->route('timeslot')->tenant_id;
    }

    public function rules(): array
    {
        return [
            'tenant_id' => ['prohibited'],
            'starts_at' => ['date_format:H:i:s'],
            'ends_at'   => ['date_format:H:i:s', 'after:starts_at'],
            'status'    => ['boolean'],
        ];
    }
}
