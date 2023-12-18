<?php

declare(strict_types=1);

namespace Tests\Unit\UrlFormatters;

use App\Core\Formatters\UrlFormatters\KCUrlFormatter;
use PHPUnit\Framework\TestCase;

class KCUrlFormatterTest extends TestCase
{
    private readonly KCUrlFormatter $formatter;

    public function setUp(): void
    {
        $this->formatter = new KCUrlFormatter();
    }

    /**
     * @group ok
     * @dataProvider dp
     */
    public function testFormat(string $expected, string $pn)
    {
        $this->assertEquals($expected, $this->formatter->format($pn));
    }

    public static function dp(): array
    {
        return [
            [
                'http://kto-zvonil.com.ua/number/044/1234567',
                '441234567'
            ],
            [
                'http://kto-zvonil.com.ua/number/067/7654321',
                '677654321'
            ],
        ];
    }

}
