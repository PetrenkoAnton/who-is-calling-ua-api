<?php

declare(strict_types=1);

namespace App\Exceptions\AppException\PhoneNumberException;

use App\Exceptions\AppException\PhoneNumberException;
use Throwable;

class UnsupportedCodePhoneNumberException extends PhoneNumberException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Unsupported operator code', $code, $previous);
    }
}
