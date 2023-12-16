<?php

declare(strict_types=1);

namespace Tests\Unit\UrlFormatters;

use App\Core\Formatters\UrlFormatters\KZUrlFormatter;
use PHPUnit\Framework\TestCase;

class KZUrlFormatterTest extends TestCase
{
    private readonly KZUrlFormatter $formatter;

    public function setUp(): void
    {
        $this->formatter = new KZUrlFormatter();
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
                'https://ktozvonil.net/nomer/0441234567',
                '441234567'
            ],
            [
                'https://ktozvonil.net/nomer/0677654321',
                '677654321'
            ],
        ];
    }

}
