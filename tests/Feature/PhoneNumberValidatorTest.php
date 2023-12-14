<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Helpers\PhoneNumberValidator;
use Tests\TestCase;

class PhoneNumberValidatorTest extends TestCase
{
    private PhoneNumberValidator $validator;

    public function setUp(): void
    {
        $this->validator = new PhoneNumberValidator();
        parent::setUp();
    }

    /**
     * @group +
     * @dataProvider dataProvider
     */
    public function testValidateSuccess(string $phone)
    {
        $this->validator->validate($phone);
        $this->expectNotToPerformAssertions();
    }

    public static function dataProvider(): array
    {
        return [
            [
                '444444444',
                '444444445',
            ],
        ];
    }

}
