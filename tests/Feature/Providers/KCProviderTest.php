<?php

declare(strict_types=1);

namespace Tests\Feature\Providers;

use App\Core\Providers\KCProvider;

class KCProviderTest extends AbstractProviderTest implements ProviderTestInterface
{
    public function getProviderClass(): string
    {
        return KCProvider::class;
    }

    /**
     * @group ok
     * @dataProvider dp
     */
    public function testSuccessfulParseComments(string $phone, array $expectedComments): void
    {
        parent::testSuccessfulParseComments($phone, $expectedComments);
    }

    public static function dp(): array
    {
        return [
            [
                '961566345',
                [
                    'Питались узнать номер карти, мошенники',
                    'Шахраї, виманюють номер карти',
                ]
            ],
            [
                '735290467',
                [
                    "+380735488532 такий самий пов'язаний номер",
                    'Аферисти',
                ]
            ],
        ];
    }
}
