<?php

namespace App\Rules;

use App\Models\ErrorCategory;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueErrorCategoryName implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (ErrorCategory::query()->where( "name" , $value )->exists()) {
            $fail('The :attribute has already been taken.');
        }
    }
}
