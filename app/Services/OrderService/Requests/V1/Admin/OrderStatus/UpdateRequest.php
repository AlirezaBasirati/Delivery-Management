<?php

namespace App\Services\OrderService\Requests\V1\Admin\OrderStatus;

use App\Services\OrderService\Enumerations\V1\OrderStatus as OrderStatusEnum;
use App\Services\OrderService\Models\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $except = $this->route('order_status')->id;

        return [
            'state_id'       => ['exists:order_states,id'],
            'next_status_id' => ['exists:order_statuses,id'],
            'title'          => ['string', 'unique:order_statuses,title,' . $except, 'max:30'],
            'name'           => ['string', 'unique:order_statuses,name,' . $except, 'max:30'],
            'sort'           => ['numeric'],
            'code'           => ['string', 'unique:order_statuses,code,' . $except, 'max:30']
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($this->route('order_status')->reserve) {
                    if (isset($this->state_id)) {
                        $validator->errors()->add('state_id', __('messages.reserved_status', ['attribute' => 'state_id']));
                    }
                    if (isset($this->name)) {
                        $validator->errors()->add('name', __('messages.reserved_status', ['attribute' => 'name']));
                    }
                    if (isset($this->code)) {
                        $validator->errors()->add('code', __('messages.reserved_status', ['attribute' => 'code']));
                    }
                    if (isset($this->sort)) {
                        $validator->errors()->add('sort', __('messages.reserved_status', ['attribute' => 'sort']));
                    }
                }

                $done_status = OrderStatus::query()->find(OrderStatusEnum::DONE->value);

                if (isset($this->sort) && $this->sort >= $done_status->sort) {
                    $validator->errors()->add('sort', __('messages.can_not_add_status_after_done_status', ['attribute' => $done_status->title]));
                }

                if ($this->next_status_id > OrderStatusEnum::DONE->value || $this->next_status_id < OrderStatusEnum::START->value) {
                    $validator->errors()->add('next_status_id', __('messages.invalid_next_status'));
                }
            }
        ];
    }
}
