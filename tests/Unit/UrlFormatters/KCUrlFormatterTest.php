<?php

declare(strict_types=1);

namespace Tests\Unit\UrlFormatters;

use App\Core\Formatters\UrlFormatters\KCUrlFormatter;
use App\Core\ProviderEnum;
use PHPUnit\Framework\TestCase;

class KCUrlFormatterTest extends TestCase
{
    private KCUrlFormatter $formatter;

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

    /**
     * @group ok
     * @dataProvider dpFor
     */
    public function testFor(ProviderEnum $invalidProvider)
    {
        $this->assertTrue($this->formatter->for(ProviderEnum::KC));
        $this->assertFalse($this->formatter->for($invalidProvider));
    }

    public static function dpFor(): array
    {
        return [
            ProviderEnum::getAllExceptOne(ProviderEnum::KC)
        ];
    }
}
