<?php

declare(strict_types=1);

namespace Tests\Feature\Providers;

use App\Core\Providers\TDProvider;

class TDProviderTest extends AbstractProviderTest
{
    protected const PROVIDER_CLASS = TDProvider::class;

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
                '443630074',
                [
                    'Коли ліг Київстар дзвонили і автомат повідомляв що введений пароль не коректний. Що це було?',
                    'Машло',
                    'Воля кабель, про підкючення каналів та пакетів, крутили запис (робот), спам.',
                    'Спам сплошной',
                    'Сбрасывают',
                    '"В ведений пароль не вірний" и так по кругу',
                    'Взяв слухавку, відразу дзвінок прирвався.',
                    'Воля кабель',
                    'дзвонять і скидають',
                ]
            ],
            [
                '730310246',
                [
                    'Englishdom',
                    'школа англійської Englishdom',
                    'Дзвонять з якоїсь школи англійської',
                    'Телефонували один раз, слухавку з невідомих номерів не беру',
                ]
            ],
        ];
    }

}
