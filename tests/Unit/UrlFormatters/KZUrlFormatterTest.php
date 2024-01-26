<?php

declare(strict_types=1);

namespace Tests\Unit\UrlFormatters;

use App\Core\Formatters\UrlFormatters\KZUrlFormatter;
use App\Core\ProviderEnum;
use PHPUnit\Framework\TestCase;

class KZUrlFormatterTest extends TestCase
{
    private KZUrlFormatter $formatter;

    public function setUp(): void
    {
        $this->formatter = new KZUrlFormatter();
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
                'https://ktozvonil.net/nomer/0441234567',
                '441234567'
            ],
            [
                'https://ktozvonil.net/nomer/0677654321',
                '677654321'
            ],
        ];
    }

    /**
     * @group ok
     * @dataProvider dpFor
     */
    public function testFor(ProviderEnum $invalidProvider): void
    {
        $this->assertTrue($this->formatter->for(ProviderEnum::KZ));
        $this->assertFalse($this->formatter->for($invalidProvider));
    }

    public static function dpFor(): array
    {
        return [
            ProviderEnum::getAllExceptOne(ProviderEnum::KZ)
        ];
    }
}
