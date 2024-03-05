<?php

namespace App\Services\OrderService\Requests\V1\Admin\OrderState;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['string', 'max:30', 'unique:order_states,title,' . $this->route('order_state')->id],
            'name'  => ['string', 'max:30', 'unique:order_states,name,' . $this->route('order_state')->id],
        ];
    }
}
