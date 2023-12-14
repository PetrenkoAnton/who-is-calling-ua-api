<?php

declare(strict_types=1);

namespace App\Rules;

use App\Exceptions\AppExceptions\PhoneNumberException;
use App\Helpers\PhoneNumberValidator;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneRule implements ValidationRule
{
    public function __construct(private readonly PhoneNumberValidator $number)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $this->number->validate($value);
        } catch (PhoneNumberException $e) {
            $fail($e->getMessage());
        }
    }
}
