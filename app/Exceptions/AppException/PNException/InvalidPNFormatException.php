<?php

declare(strict_types=1);

namespace App\Exceptions\AppException\PNException;

use App\Exceptions\AppException\PNException;
use Throwable;

class InvalidPNFormatException extends PNException
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Invalid phone number format', $code, $previous);
    }
}
