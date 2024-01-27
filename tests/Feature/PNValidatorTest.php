<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Core\Validators\PNValidator;
use App\Exceptions\AppException;
use App\Exceptions\AppException\PNException\InvalidPNFormatException;
use App\Exceptions\AppException\PNException\NumericPNException;
use App\Exceptions\AppException\PNException\UnsupportedCodePNException;
use Tests\TestCase;

class PNValidatorTest extends TestCase
{
    private PNValidator $validator;

    public function setUp(): void
    {
        parent::setUp();
        $this->validator = $this->app->make(PNValidator::class);
    }

    /**
     * @group ok
     * @dataProvider dpValid
     */
    public function testValidateSuccess(string $pn): void
    {
        $this->validator->validate($pn);
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
    public function testValidateThrowsException(string $pn, AppException $e): void
    {
        $this->expectException($e::class);
        $this->validator->validate($pn);
    }

    public static function dpInvalid(): array
    {
        return [
            ['qwerty', new NumericPNException],
            ['q', new NumericPNException],
            ['q71234567', new NumericPNException],

            ['0', new InvalidPNFormatException],
            ['000', new InvalidPNFormatException],
            ['123123', new InvalidPNFormatException],
            ['0010000000000000000000', new InvalidPNFormatException],

            ['001000000', new UnsupportedCodePNException],
            ['431234567', new UnsupportedCodePNException],
            ['927654321', new UnsupportedCodePNException],
        ];
    }
}
