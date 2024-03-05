<?php

namespace App\Services\CustomerService\Requests\V1\Common\Customer;

use App\Services\CustomerService\Enumerations\Type;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class IndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type'         => [new Enum(Type::class)],
            'created_from' => ['date'],
            'created_to'   => ['date'],
        ];
    }
}
