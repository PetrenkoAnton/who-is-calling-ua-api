<?php

declare(strict_types=1);

namespace Tests\Unit\UrlFormatters;

use App\Core\Formatters\UrlFormatters\CIUrlFormatter;
use PHPUnit\Framework\TestCase;

class CIUrlFormatterTest extends TestCase
{
    private readonly CIUrlFormatter $formatter;

    public function setUp(): void
    {
        $this->formatter = new CIUrlFormatter();
    }

    /**
     * @group ok
     * @dataProvider dataProvider
     */
    public function testFormat(string $expected, string $phone)
    {
        $this->assertEquals($expected, $this->formatter->format($phone));
    }

    public static function dataProvider(): array
    {
        return [
            [
                'https://www.callinsider.com.ua/ua/0441234567',
                '441234567'
            ],
            [
                'https://www.callinsider.com.ua/ua/0677654321',
                '677654321'
            ],
        ];
    }

}
