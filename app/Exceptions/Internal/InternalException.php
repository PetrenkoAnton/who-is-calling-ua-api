<?php

declare(strict_types=1);

namespace App\Exceptions\Internal;

use App\Exceptions\AppException;

class InternalException extends AppException
{
    public function __construct(string $message, int $code = self::INTERNAL_ERROR)
    {
        parent::__construct(
            message: $message,
            code: $code,
        );
    }
}
