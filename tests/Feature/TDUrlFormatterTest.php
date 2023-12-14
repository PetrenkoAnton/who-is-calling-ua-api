<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Helpers\KZUrlFormatter;
use App\Helpers\TDUrlFormatter;
use Tests\TestCase;

class TDUrlFormatterTest extends TestCase
{
    private TDUrlFormatter $tdUrlFormatter;

    public function setUp(): void
    {
        $this->tdUrlFormatter = new TDUrlFormatter();
    }

    /**
     * @group ok
     * @dataProvider dataProvider
     */
    public function testFormat(string $expected, string $phone)
    {
        $this->assertEquals($expected, $this->tdUrlFormatter->format($phone));
    }

    public static function dataProvider(): array
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
