<?php

declare(strict_types=1);

namespace Tests\Feature\Validators;

use App\Core\Validators\PNRule;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class PNRuleTest extends TestCase
{
    private readonly PNRule $rule;

    public function setUp(): void
    {
        parent::setUp();
        $this->rule = $this->app->make(PNRule::class);
    }

    /**
     * @group ok
     * @dataProvider dpValidateSuccess
     */
    public function testValidateSuccess(string $pn): void
    {
        $validator = Validator::make(['pn' => $pn], ['pn' => $this->rule]);
        $this->assertFalse($validator->fails());
    }

    public static function dpValidateSuccess(): array
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
    public function testValidateFail(string $pn, string $message): void
    {
        $validator = Validator::make(['pn' => $pn], ['pn' => $this->rule]);
        $this->assertTrue($validator->fails());

        $this->assertEquals($validator->getMessageBag()->messages()['pn'][0], $message);
    }

    public static function dpInvalid(): array
    {
        return [
            ['qwerty', 'Not numeric phone number'],
            ['q', 'Not numeric phone number'],
            ['q71234567', 'Not numeric phone number'],
            //
            ['0', 'Invalid phone number format'],
            ['000', 'Invalid phone number format'],
            ['123123', 'Invalid phone number format'],
            ['0010000000000000000000', 'Invalid phone number format'],
            //
            ['001000000', 'Unsupported operator code'],
            ['431234567', 'Unsupported operator code'],
            ['927654321', 'Unsupported operator code'],
        ];
    }
}
