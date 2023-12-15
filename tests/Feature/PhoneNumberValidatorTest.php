<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Core\Validators\PhoneNumberValidator;
use App\Exceptions\AppException\PhoneNumberException\InvalidPhoneNumberFormatException;
use App\Exceptions\AppException\PhoneNumberException\NumericPhoneNumberException;
use App\Exceptions\AppException\PhoneNumberException\UnsupportedCodePhoneNumberException;
use Tests\TestCase;

class PhoneNumberValidatorTest extends TestCase
{
    private PhoneNumberValidator $validator;

    public function setUp(): void
    {
        parent::setUp();
        $this->validator = $this->app->make(PhoneNumberValidator::class);
    }

    /**
     * @group ok
     * @dataProvider validDataProvider
     */
    public function testValidateSuccess(string $phone)
    {
        $this->validator->validate($phone);
        $this->expectNotToPerformAssertions();
    }

    public static function validDataProvider(): array
    {
        return [
            [
                '440000000',
                '440000001',
                '633333333',
                '670123456',
                '999999999',
            ],
        ];
    }

    /**
     * @group ok
     * @dataProvider invalidDataProvider
     */
    public function testValidateThrowsException(string $phone, string $e)
    {
        $this->expectException($e);
        $this->validator->validate($phone);
    }

    public static function invalidDataProvider(): array
    {
        return [
            ['qwerty', NumericPhoneNumberException::class],
            ['q', NumericPhoneNumberException::class],
            ['q71234567', NumericPhoneNumberException::class],

            ['0', InvalidPhoneNumberFormatException::class],
            ['000', InvalidPhoneNumberFormatException::class],
            ['123123', InvalidPhoneNumberFormatException::class],
            ['0010000000000000000000', InvalidPhoneNumberFormatException::class],

            ['001000000', UnsupportedCodePhoneNumberException::class],
            ['431234567', UnsupportedCodePhoneNumberException::class],
            ['927654321', UnsupportedCodePhoneNumberException::class],
        ];
    }

}
