<?php

declare(strict_types=1);

namespace Tests\Unit\UrlFormatters;

use App\Core\Formatters\UrlFormatters\CIUrlFormatter;
use App\Core\ProviderEnum;
use PHPUnit\Framework\TestCase;

class CIUrlFormatterTest extends TestCase
{
    private CIUrlFormatter $formatter;

    public function setUp(): void
    {
        $this->formatter = new CIUrlFormatter();
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
                'https://www.callinsider.com.ua/ua/0441234567',
                '441234567',
            ],
            [
                'https://www.callinsider.com.ua/ua/0677654321',
                '677654321',
            ],
        ];
    }

    /**
     * @group ok
     * @dataProvider dpFor
     */
    public function testFor(ProviderEnum $invalidProvider): void
    {
        $this->assertTrue($this->formatter->for(ProviderEnum::CI));
        $this->assertFalse($this->formatter->for($invalidProvider));
    }

    public static function dpFor(): array
    {
        return [
            ProviderEnum::getAllExceptOne(ProviderEnum::CI),
        ];
    }
}
