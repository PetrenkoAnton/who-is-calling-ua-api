<?php

declare(strict_types=1);

namespace App\Exceptions\AppExceptions\PhoneNumberExceptions;

use App\Exceptions\AppExceptions\PhoneNumberException;
use Throwable;

class InvalidPhoneNumberFormatException extends PhoneNumberException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Invalid phone number format', $code, $previous);
    }
}
