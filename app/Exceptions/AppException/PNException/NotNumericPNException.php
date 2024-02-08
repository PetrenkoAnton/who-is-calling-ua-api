<?php

declare(strict_types=1);

namespace App\Exceptions\AppException\PNException;

use App\Exceptions\AppException\PNException;

final class NotNumericPNException extends PNException
{
    public function __construct()
    {
        parent::__construct(
            message: 'Not numeric phone number',
            code: self::NOT_NUMERIC_PN,
        );
    }
}
