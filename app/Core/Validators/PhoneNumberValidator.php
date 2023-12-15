<?php

declare(strict_types=1);

namespace App\Core\Validators;

use App\Exceptions\AppException\PhoneNumberException\InvalidPhoneNumberFormatException;
use App\Exceptions\AppException\PhoneNumberException\NumericPhoneNumberException;
use App\Exceptions\AppException\PhoneNumberException\UnsupportedCodePhoneNumberException;

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
