<?php

declare(strict_types=1);

namespace Tests\Unit\UrlFormatters;

use App\Core\Formatters\UrlFormatters\CFUrlFormatter;
use App\Core\ProviderEnum;
use PHPUnit\Framework\TestCase;

class CFUrlFormatterTest extends TestCase
{
    private readonly CFUrlFormatter $formatter;

    public function setUp(): void
    {
        $this->formatter = new CFUrlFormatter();
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
                'https://callfilter.app/380441234567',
                '441234567'
            ],
            [
                'https://callfilter.app/380677654321',
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
        $this->assertTrue($this->formatter->for(ProviderEnum::CF));
        $this->assertFalse($this->formatter->for($invalidProvider));
    }

    public static function dpFor(): array
    {
        return [
            ProviderEnum::getAllExceptOne(ProviderEnum::CF)
        ];
    }
}
