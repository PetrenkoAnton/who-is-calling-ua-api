<?php

declare(strict_types=1);

namespace App\Core\Validators;

use App\Exceptions\AppException\PNException\InvalidPNFormatException;
use App\Exceptions\AppException\PNException\NumericPNException;
use App\Exceptions\AppException\PNException\UnsupportedCodePNException;

class PhoneNumberValidator
{
    /**
     * @throws NumericPNException
     * @throws InvalidPNFormatException
     * @throws UnsupportedCodePNException
     */
    public function validate(string $phone): void
    {
        $this->validateNumeric($phone);

        $this->validateLength($phone);

        $this->validateSupportedOperatorCode($phone);
    }

    /**
     * @throws NumericPNException
     */
    private function validateNumeric(string $phone): void
    {
        if (!is_numeric($phone))
            throw new NumericPNException();
    }

    /**
     * @throws InvalidPNFormatException
     */
    private function validateLength(string $phone): void
    {
        if (strlen($phone) !== 9)
            throw new InvalidPNFormatException();
    }

    /**
     * @throws UnsupportedCodePNException
     */
    private function validateSupportedOperatorCode(string $phone): void
    {
        if (!in_array(substr($phone, 0, 2), config('phone.supported')))
            throw new UnsupportedCodePNException();
    }
}
