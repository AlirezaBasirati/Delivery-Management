<?php

namespace App\Services\OrderService\Requests\V1\Admin\OrderState;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'unique:order_states,title', 'max:30'],
            'name'  => ['required', 'string', 'unique:order_states,name', 'max:30'],
        ];
    }
}
