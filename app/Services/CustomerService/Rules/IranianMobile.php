<?php

namespace App\Services\CustomerService\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class IranianMobile implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^((0)(9){1}[0-9]{9})+$/', $value)) {
            $fail(
                 __('validation.ir_mobile')
            );
        }
    }
}
