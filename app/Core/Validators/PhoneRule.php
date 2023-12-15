<?php

declare(strict_types=1);

namespace App\Core\Validators;

use App\Exceptions\AppException\PhoneNumberException;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneRule implements ValidationRule
{
    public function __construct(private readonly PhoneNumberValidator $numberValidator)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $this->numberValidator->validate($value);
        } catch (PhoneNumberException $e) {
            $fail($e->getMessage());
        }
    }
}
