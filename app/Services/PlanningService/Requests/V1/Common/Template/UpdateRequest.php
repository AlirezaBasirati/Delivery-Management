<?php

namespace App\Services\PlanningService\Requests\V1\Common\Template;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->tenant_id == $this->route('template')->tenant_id;
    }

    public function rules(): array
    {
        return [
            'tenant_id' => ['prohibited'],
            'name'      => ['string', 'max:30'],
        ];
    }
}
