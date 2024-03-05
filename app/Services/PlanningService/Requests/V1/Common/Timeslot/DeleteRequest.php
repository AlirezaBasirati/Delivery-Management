<?php

namespace App\Services\PlanningService\Requests\V1\Common\Timeslot;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->tenant_id == $this->route('template')->tenant_id;
    }

    public function rules(): array
    {
        return [];
    }
}
