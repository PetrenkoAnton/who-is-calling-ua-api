<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class AppException extends Exception
{
    protected const INVALID_FORMAT_PN = 100;
    protected const NOT_NUMERIC_PN = 101;
    protected const UNSUPPORTED_CODE_PN = 102;

    protected const INTERNAL_ERROR = 500;

    protected function __construct(string $message, int $code)
    {
        parent::__construct(
            message: $message,
            code: $code,
        );
    }
}
