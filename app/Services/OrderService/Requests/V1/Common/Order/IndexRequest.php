<?php

namespace App\Services\OrderService\Requests\V1\Common\Order;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Schema;

class IndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'columns'      => ['nullable', 'array'],
            'columns.*'    => [
                function ($attribute, $value, $fail) {
                    if (!Schema::hasColumn('orders', $value)) {
                        $fail(__('validation.exists', ['attribute' => $attribute]));
                    }
                }
            ],
            'ids'          => ['nullable', 'array'],
            'ids.*'        => ['exists:orders,id'],
            'created_from' => ['date'],
            'created_to'   => ['date'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'created_from' => $this->created_from ?? Carbon::today()
        ]);
    }
}
