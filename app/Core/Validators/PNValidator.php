<?php

declare(strict_types=1);

namespace App\Core\Validators;

use App\Exceptions\AppException\PNException\InvalidPNFormatException;
use App\Exceptions\AppException\PNException\NumericPNException;
use App\Exceptions\AppException\PNException\UnsupportedCodePNException;

class PNValidator
{
    /**
     * @throws NumericPNException
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
     * @throws NumericPNException
     */
    private function validateNumeric(string $pn): void
    {
        if (!is_numeric($pn))
            throw new NumericPNException();
    }

    /**
     * @throws InvalidPNFormatException
     */
    private function validateLength(string $pn): void
    {
        if (strlen($pn) !== 9)
            throw new InvalidPNFormatException();
    }

    /**
     * @throws UnsupportedCodePNException
     */
    private function validateSupportedOperatorCode(string $pn): void
    {
        if (!in_array(substr($pn, 0, 2), config('pn.supported_codes')))
            throw new UnsupportedCodePNException();
    }
}
