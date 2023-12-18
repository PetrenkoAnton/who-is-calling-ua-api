<?php

declare(strict_types=1);

namespace Tests\Unit\UrlFormatters;

use App\Core\Formatters\UrlFormatters\TDUrlFormatter;
use PHPUnit\Framework\TestCase;

class TDUrlFormatterTest extends TestCase
{
    private readonly TDUrlFormatter $tdUrlFormatter;

    public function setUp(): void
    {
        $this->tdUrlFormatter = new TDUrlFormatter();
    }

    /**
     * @group ok
     * @dataProvider dp
     */
    public function testFormat(string $expected, string $pn)
    {
        $this->assertEquals($expected, $this->tdUrlFormatter->format($pn));
    }

    public static function dp(): array
    {
        return [
            [
                'https://www.telefonnyjdovidnyk.com.ua/nomer/0441234567',
                '441234567'
            ],
            [
                'https://www.telefonnyjdovidnyk.com.ua/nomer/0677654321',
                '677654321'
            ],
        ];
    }

}
