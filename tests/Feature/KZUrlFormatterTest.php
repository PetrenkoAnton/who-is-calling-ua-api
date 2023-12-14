<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Helpers\KZUrlFormatter;
use Tests\TestCase;

class KZUrlFormatterTest extends TestCase
{
    private KZUrlFormatter $kzUrlFormatter;

    public function setUp(): void
    {
        $this->kzUrlFormatter = new KZUrlFormatter();
    }

    /**
     * @group ok
     * @dataProvider dataProvider
     */
    public function testFormat(string $expected, string $phone)
    {
        $this->assertEquals($expected, $this->kzUrlFormatter->format($phone));
    }

    public static function dataProvider(): array
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
