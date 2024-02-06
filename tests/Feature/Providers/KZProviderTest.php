<?php

declare(strict_types=1);

namespace Tests\Feature\Providers;

use App\Core\Providers\KZProvider;

class KZProviderTest extends AbstractProviderTest implements ProviderTestInterface
{
    public function getProviderClass(): string
    {
        return KZProvider::class;
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
                '730909161',
                [
                    'Мовчать...',
                    'Позвонили я ничего не говорила , и сразу же сбросили',
                    'на лінії тишина',
                    'Звонят и молчат',
                    'позвонили, услышали голос и сразу сбросили.',
                ]
            ],
            [
                '969402323',
                [
                    'Обережно! Шахрай, берег передплату за товар, але посилку не відсилає! На дзвінки, після отримання коштів, не відповідає!',
                ]
            ],
        ];
    }
}
