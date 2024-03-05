<?php

namespace App\Services\PlanningService\Requests\V1\Common\Timeslot;

use App\Services\AuthenticationService\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tenant_id' => ['required'],
            'starts_at' => ['required', 'date_format:H:i:s'],
            'ends_at'   => ['required', 'date_format:H:i:s', 'after:starts_at'],
            'status'    => ['required', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        /** @var User $user */
        $user = $this->user();

        $this->merge([
            'tenant_id' => $user->tenant_id
        ]);
    }
}
