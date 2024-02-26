<?php

declare(strict_types=1);

namespace App\Exceptions\AppException\PNException;

use App\Exceptions\AppException\PNException;

final class UnsupportedCodePNException extends PNException
{
    public function __construct()
    {
        parent::__construct(
            message: 'Unsupported operator code',
            code: self::UNSUPPORTED_CODE_PN,
        );
    }
}
