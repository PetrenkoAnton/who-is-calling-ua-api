<?php

declare(strict_types=1);

namespace App\Core\Validators;

use App\Exceptions\AppException\PNException\InvalidPNFormatException;
use App\Exceptions\AppException\PNException\NotNumericPNException;
use App\Exceptions\AppException\PNException\UnsupportedCodePNException;

use function config;
use function in_array;
use function is_numeric;
use function strlen;
use function substr;

class PNValidator
{
    /**
     * @throws NotNumericPNException
     * @throws InvalidPNFormatException
     * @throws UnsupportedCodePNException
     */
    public function validate(string $pn): void
    {
        $this->validateNumeric($pn);

        $this->validateLength($pn);

        $this->validateSupportedOperatorCode($pn);
    }

    /**
     * @throws NotNumericPNException
     */
    private function validateNumeric(string $pn): void
    {
        if (!is_numeric($pn)) {
            throw new NotNumericPNException();
        }
    }

    /**
     * @throws InvalidPNFormatException
     */
    private function validateLength(string $pn): void
    {
        if (strlen($pn) !== 9) {
            throw new InvalidPNFormatException();
        }
    }

    /**
     * @throws UnsupportedCodePNException
     */
    private function validateSupportedOperatorCode(string $pn): void
    {
        if (!in_array(substr($pn, 0, 2), config('pn.supported_codes'))) {
            throw new UnsupportedCodePNException();
        }
    }
}
