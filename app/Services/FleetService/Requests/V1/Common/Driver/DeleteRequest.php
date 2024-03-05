<?php

namespace App\Services\FleetService\Requests\V1\Common\Driver;

use App\Services\FleetService\Models\Driver;
use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Driver $driver */
        $driver = $this->route('driver');

        return $driver->tenant_id == auth()->user()->tenant_id;
    }
}
