<?php

declare(strict_types=1);

namespace Tests\Unit\UrlFormatters;

use App\Core\Formatters\UrlFormatters\SLUrlFormatter;
use PHPUnit\Framework\TestCase;

class SLUrlFormatterTest extends TestCase
{
    private readonly SLUrlFormatter $formatter;

    public function setUp(): void
    {
        $this->formatter = new SLUrlFormatter();
    }

    /**
     * @group ok
     * @dataProvider dp
     */
    public function testFormat(string $expected, string $phone)
    {
        $this->assertEquals($expected, $this->formatter->format($phone));
    }

    public static function dp(): array
    {
        return [
            [
                'https://slick.ly/ua/0441234567',
                '441234567'
            ],
            [
                'https://slick.ly/ua/0677654321',
                '677654321'
            ],
        ];
    }

}
