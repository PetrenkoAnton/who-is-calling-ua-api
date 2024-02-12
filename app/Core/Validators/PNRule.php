<?php

declare(strict_types=1);

namespace App\Core\Validators;

use App\Exceptions\AppException\PNException;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PNRule implements ValidationRule
{
    public function __construct(private readonly PNValidator $validator)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $this->validator->validate($value);
        } catch (PNException $e) {
            $fail($e->getMessage());
        }
    }
}
