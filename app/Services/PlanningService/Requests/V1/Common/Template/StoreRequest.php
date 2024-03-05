<?php

namespace App\Services\PlanningService\Requests\V1\Common\Template;

use App\Services\AuthenticationService\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tenant_id'           => ['required'],
            'name'                => ['required', 'string', 'max:30'],
            'items'               => ['required', 'array'],
            'items.*.day_of_week' => ['required', 'between:1,7'],
            'items.*.timeslot_id' => ['required', 'exists:timeslots,id'],
            'items.*.capacity'    => ['required', 'numeric'],
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
