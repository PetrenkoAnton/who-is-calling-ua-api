<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Core\Validators\PhoneNumberValidator;
use App\Exceptions\AppException\PNException\InvalidPNFormatException;
use App\Exceptions\AppException\PNException\NumericPNException;
use App\Exceptions\AppException\PNException\UnsupportedCodePNException;
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
     * @dataProvider dpValid
     */
    public function testValidateSuccess(string $phone)
    {
        $this->validator->validate($phone);
        $this->expectNotToPerformAssertions();
    }

    public static function dpValid(): array
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
     * @dataProvider dpInvalid
     */
    public function testValidateThrowsException(string $phone, string $e)
    {
        $this->expectException($e);
        $this->validator->validate($phone);
    }

    public static function dpInvalid(): array
    {
        return [
            ['qwerty', NumericPNException::class],
            ['q', NumericPNException::class],
            ['q71234567', NumericPNException::class],

            ['0', InvalidPNFormatException::class],
            ['000', InvalidPNFormatException::class],
            ['123123', InvalidPNFormatException::class],
            ['0010000000000000000000', InvalidPNFormatException::class],

            ['001000000', UnsupportedCodePNException::class],
            ['431234567', UnsupportedCodePNException::class],
            ['927654321', UnsupportedCodePNException::class],
        ];
    }

}
