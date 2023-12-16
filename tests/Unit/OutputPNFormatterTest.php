<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\Formatters\OutputPNFormatter;
use PHPUnit\Framework\TestCase;

class OutputPNFormatterTest extends TestCase
{
    private readonly OutputPNFormatter $formatter;

    public function setUp(): void
    {
        $this->formatter = new OutputPNFormatter();
    }

    /**
     * @group ok
     * @dataProvider dp
     */
    public function testFormat(string $phone, string $expected)
    {
        $this->assertEquals($expected, $this->formatter->format($phone));
    }

    public static function dp(): array
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
