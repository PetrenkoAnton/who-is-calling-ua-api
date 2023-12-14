<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Helpers\OutputPhoneNumberFormatter;
use Tests\TestCase;

class OutputPhoneNumberFormatterTest extends TestCase
{
    private readonly OutputPhoneNumberFormatter $formatter;

    public function setUp(): void
    {
        $this->formatter = new OutputPhoneNumberFormatter();
    }

    /**
     * @group ok
     * @dataProvider dataProvider
     */
    public function testFormat(string $phone, string $expected)
    {
        $this->assertEquals($expected, $this->formatter->format($phone));
    }

    public static function dataProvider(): array
    {
        return [
            [
                '441234567',
                '044 123-45-67',
            ],
            [
                '670000000',
                '067 000-00-00',
            ],
        ];
    }

}
