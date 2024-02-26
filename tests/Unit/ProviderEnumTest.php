<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\ProviderEnum;
use PHPUnit\Framework\TestCase;

class ProviderEnumTest extends TestCase
{
    /**
     * @group ok
     * @dataProvider dp
     */
    public function testGetAllExceptOne(ProviderEnum $except, array $expected): void
    {
        $this->assertEquals($expected, ProviderEnum::getAllExceptOne($except));
    }

    public static function dp(): array
    {
        return [
            [
                ProviderEnum::CF,
                [
                    1 => ProviderEnum::CI,
                    2 => ProviderEnum::KC,
                    3 => ProviderEnum::KZ,
                    4 => ProviderEnum::SL,
                    5 => ProviderEnum::TD,
                ],
            ],
            [
                ProviderEnum::CI,
                [
                    0 => ProviderEnum::CF,
                    2 => ProviderEnum::KC,
                    3 => ProviderEnum::KZ,
                    4 => ProviderEnum::SL,
                    5 => ProviderEnum::TD,
                ],
            ],
            [
                ProviderEnum::KC,
                [
                    0 => ProviderEnum::CF,
                    1 => ProviderEnum::CI,
                    3 => ProviderEnum::KZ,
                    4 => ProviderEnum::SL,
                    5 => ProviderEnum::TD,
                ],
            ],
            [
                ProviderEnum::KZ,
                [
                    0 => ProviderEnum::CF,
                    1 => ProviderEnum::CI,
                    2 => ProviderEnum::KC,
                    4 => ProviderEnum::SL,
                    5 => ProviderEnum::TD,
                ],
            ],
            [
                ProviderEnum::SL,
                [
                    0 => ProviderEnum::CF,
                    1 => ProviderEnum::CI,
                    2 => ProviderEnum::KC,
                    3 => ProviderEnum::KZ,
                    5 => ProviderEnum::TD,
                ],
            ],
            [
                ProviderEnum::TD,
                [
                    0 => ProviderEnum::CF,
                    1 => ProviderEnum::CI,
                    2 => ProviderEnum::KC,
                    3 => ProviderEnum::KZ,
                    4 => ProviderEnum::SL,
                ],
            ],
        ];
    }
}
