<?php

declare(strict_types=1);

namespace App\Exceptions\AppException\PhoneNumberException;

use App\Exceptions\AppException\PhoneNumberException;
use Throwable;

class NumericPhoneNumberException extends PhoneNumberException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Not numeric', $code, $previous);
    }
}
