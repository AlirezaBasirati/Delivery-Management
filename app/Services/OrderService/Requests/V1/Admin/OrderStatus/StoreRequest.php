<?php

namespace App\Services\OrderService\Requests\V1\Admin\OrderStatus;

use App\Services\OrderService\Enumerations\V1\OrderStatus as OrderStatusEnum;
use App\Services\OrderService\Models\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'state_id'       => ['required', 'exists:order_states,id'],
            'next_status_id' => ['required', 'exists:order_statuses,id'],
            'title'          => ['required', 'string', 'unique:order_statuses,title', 'max:30'],
            'name'           => ['required', 'string', 'unique:order_statuses,name', 'max:30'],
            'sort'           => ['required', 'numeric'],
            'code'           => ['required', 'string', 'unique:order_statuses,code', 'max:30']
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $done_status = OrderStatus::query()->find(OrderStatusEnum::DONE->value);

                if ($this->sort >= $done_status->sort) {
                    $validator->errors()->add('sort', __('messages.can_not_add_status_after_done_status', ['attribute' => $done_status->title]));
                }

                if ($this->next_status_id > OrderStatusEnum::DONE->value || $this->next_status_id < OrderStatusEnum::START->value) {
                    $validator->errors()->add('next_status_id', __('messages.invalid_next_status'));
                }
            }
        ];
    }
}
