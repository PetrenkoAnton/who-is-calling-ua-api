<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Exceptions\AppExceptions\PhoneNumberExceptions\InvalidPhoneNumberFormatException;
use App\Exceptions\AppExceptions\PhoneNumberExceptions\NumericPhoneNumberException;
use App\Exceptions\AppExceptions\PhoneNumberExceptions\UnsupportedCodePhoneNumberException;

class PhoneNumberValidator
{
    public function validate(string $phone): void
    {
        $this->validateNumeric($phone);

        $this->validateLength($phone);

        $this->validateSupportedOperatorCode($phone);
    }

    private function validateNumeric(string $phone): void
    {
        if (!is_numeric($phone))
            throw new NumericPhoneNumberException();
    }

    private function validateLength(string $phone): void
    {
        if (strlen($phone) != 9)
            throw new InvalidPhoneNumberFormatException();
    }

    private function validateSupportedOperatorCode(string $phone): void
    {
        $code = substr($phone, 0, 2);

        if (!in_array($code, config('phone.supported')))
            throw new UnsupportedCodePhoneNumberException();
    }
}
