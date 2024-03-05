<?php

namespace App\Services\FleetService\Requests\V1\Admin\DriverLocation;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'driver_id' => ['required', 'exists:drivers,id'],
            'from'      => ['required', 'date']
        ];
    }
}
