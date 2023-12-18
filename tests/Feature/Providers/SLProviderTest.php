<?php

declare(strict_types=1);

namespace Tests\Feature\Providers;

use App\Core\Providers\SLProvider;

class SLProviderTest extends AbstractProviderTest
{
    protected const PROVIDER_CLASS = SLProvider::class;

    /**
     * @group ok
     * @dataProvider dp
     */
    public function testSuccessfulParseComments(string $phone, array $expectedComments)
    {
        parent::testSuccessfulParseComments($phone, $expectedComments);
    }

    public static function dp(): array
    {
        return [
            [
                '979940946',
                [
                    'Это троллинг пророссийского тролля не ведитесь.',
                    'Неадекватный тролль из проспекта Тракторостроителей 107, Салтовский р-он Харькова.',
                    'Я тролль с Джумайловки живу на Улице Александра Безгласного.Я люблю мошенничать и обманывать.Это мое хобби.А еще торгую своим лицом на дороге у обочины.',
                    'Данный номер телефона утерян.Пожалуйста не реагируйте на данную публикацию.',
                ]
            ],
            [
                '939300040',
                [
                    'Обманывает',
                    'Розводяга',
                    'Мошенники',
                ]
            ],
        ];
    }

}
