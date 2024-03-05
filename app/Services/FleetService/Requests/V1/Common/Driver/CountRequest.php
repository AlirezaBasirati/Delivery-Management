<?php

namespace App\Services\FleetService\Requests\V1\Common\Driver;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Schema;

class CountRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'group_by_column' => [
                function ($attribute, $value, $fail) {
                    if (!Schema::hasColumn('drivers', $value)) {
                        $fail(__('validation.exists', ['attribute' => $attribute]));
                    }
                }
            ]
        ];
    }
}
