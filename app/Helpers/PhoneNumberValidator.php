<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Exceptions\AppExceptions\PhoneNumberExceptions\InvalidPhoneNumberFormatException;
use App\Exceptions\AppExceptions\PhoneNumberExceptions\NumericPhoneNumberException;
use App\Exceptions\AppExceptions\PhoneNumberExceptions\UnsupportedCodePhoneNumberException;

class PhoneNumberValidator
{
    /**
     * @throws NumericPhoneNumberException
     * @throws InvalidPhoneNumberFormatException
     * @throws UnsupportedCodePhoneNumberException
     */
    public function validate(string $phone): void
    {
        $this->validateNumeric($phone);

        $this->validateLength($phone);

        $this->validateSupportedOperatorCode($phone);
    }

    /**
     * @throws NumericPhoneNumberException
     */
    private function validateNumeric(string $phone): void
    {
        if (!is_numeric($phone))
            throw new NumericPhoneNumberException();
    }

    /**
     * @throws InvalidPhoneNumberFormatException
     */
    private function validateLength(string $phone): void
    {
        if (strlen($phone) !== 9)
            throw new InvalidPhoneNumberFormatException();
    }

    /**
     * @throws UnsupportedCodePhoneNumberException
     */
    private function validateSupportedOperatorCode(string $phone): void
    {
        if (!in_array(substr($phone, 0, 2), config('phone.supported')))
            throw new UnsupportedCodePhoneNumberException();
    }
}
