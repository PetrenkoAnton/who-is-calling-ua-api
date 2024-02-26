<?php

declare(strict_types=1);

namespace App\Exceptions\AppException\PNException;

use App\Exceptions\AppException\PNException;

final class InvalidPNFormatException extends PNException
{
    public function __construct()
    {
        parent::__construct(
            message: 'Invalid phone number format',
            code: self::INVALID_FORMAT_PN,
        );
    }
}
