<?php

declare(strict_types=1);

namespace Tests\Unit\UrlFormatters;

use App\Core\Formatters\UrlFormatters\TDUrlFormatter;
use PHPUnit\Framework\TestCase;

class TDUrlFormatterTest extends TestCase
{
    private TDUrlFormatter $formatter;

    public function setUp(): void
    {
        $this->formatter = new TDUrlFormatter();
    }

    /**
     * @group ok
     * @dataProvider dp
     */
    public function testFormat(string $expected, string $pn): void
    {
        $this->assertEquals($expected, $this->formatter->format($pn));
    }

    public static function dp(): array
    {
        return [
            [
                'https://www.telefonnyjdovidnyk.com.ua/nomer/0441234567',
                '441234567',
            ],
            [
                'https://www.telefonnyjdovidnyk.com.ua/nomer/0677654321',
                '677654321',
            ],
        ];
    }
}
