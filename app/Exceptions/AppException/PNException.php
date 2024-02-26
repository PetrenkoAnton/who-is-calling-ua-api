<?php

declare(strict_types=1);

namespace App\Exceptions\AppException;

use App\Exceptions\AppException;

class PNException extends AppException
{
    protected function __construct(string $message, int $code)
    {
        parent::__construct(
            message: $message,
            code: $code,
        );
    }
}
