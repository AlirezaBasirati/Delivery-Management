<?php

namespace App\Services\OrderService\Requests\V1\Driver\Order;

use App\Services\OrderService\Repository\V1\Driver\Order\OrderInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ChangeStatusRequest extends FormRequest
{
    public function __construct(private readonly OrderInterface $orderService)
    {
        parent::__construct();
    }

    public function rules(): array
    {
        return [];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (! $this->status?->for_driver) {
                    $validator->errors()->add('status_id', __('messages.can_not_change_status'));
                }
            }
        ];
    }

    protected function prepareForValidation(): void
    {
        $order = $this->orderService->current();

        $this->merge([
            'order' => $order,
            'status' => $order?->next_status
        ]);
    }
}
