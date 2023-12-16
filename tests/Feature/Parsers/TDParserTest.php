<?php

declare(strict_types=1);

namespace Tests\Feature\Parsers;

use App\Core\Parsers\TDParser;
use Tests\TestCase;

class TDParserTest extends TestCase
{
    private TDParser $commentFormatter;

    public function setUp(): void
    {
        parent::setUp();
        $this->commentFormatter = $this->app->make(TDParser::class);
    }

    /**
     * @group ok
     */
    public function testGetExpression()
    {
        $this->assertEquals('.comment-item .comment .comment-text', $this->commentFormatter->getExpression());
    }

    /**
     * @group ok
     * @dataProvider dataProviderFormat
     */
    public function testFormat(string $expected, string $raw)
    {
        $this->assertEquals($expected, $this->commentFormatter->format($raw));
    }

    public static function dataProviderFormat(): array
    {
        return [
            [
                'Шахраї !  Не беріть з цього номеру. Краще в спам одразу ж відправляти !',
                "Шахраї !  Не беріть з цього номеру. Краще в спам одразу ж відправляти !"
            ],
        ];
    }

    /**
     * @group ok
     * @dataProvider dataProviderIgnore
     */
    public function testIgnore(bool $expected, string $comment)
    {
        $this->assertEquals($expected, $this->commentFormatter->ignore($comment));
    }

    public static function dataProviderIgnore(): array
    {
        return [
            [
                true,
                'Повідомлення від адміністратора сайту telefonnyjdovidnyk.com.ua  «Допоможіть іншим відвідувачам сайту тим, що поділитеся з ними своїм досвідом спілкування з цим абонентом. Коли Вам з цього номеру телефонували і як часто? Що було предметом розмови, якщо Ви підняли трубку? Коментар, який Ви відіслали, буде показаний на цьому сайті.»  ',
            ],
            [
                true,
                'Інші коментарі про цей номер телефону можна знайти на сайті партнера: www.cejnomer.ru  (2×)',
            ],
            [
                true,
                'Інші коментарі про цей номер телефону можна знайти на сайті партнера: www.spravocnik.ru  (1×)',
            ],
            [
                true,
                'Інші коментарі про цей номер телефону можна знайти на сайті партнера: www.najtinomer.ru  (1×)'
            ],
            [
                true,
                'Інші коментарі про цей номер телефону можна знайти на сайті партнера: www.callinsider.com.ua  (6×)'
            ],
            [
                true,
                'Коментар про цей номер телефону можна знайти на сайті партнера: www.cejnomer.ru  (1×)'
            ],
            [
                true,
                'Коментар про цей номер телефону можна знайти на сайті партнера: www.callinsider.com.ua  (1×)'
            ],
            [
                true,
                'Цей коментар був на прохання тимчасово видалений. Модератори будуть розглядати цей запит якомога швидше.'
            ],
            [
                false,
                'Мне позвонила девушка и не представившись сказала, что я выиграла 380 тысяч гривен. Нажмите один и мы вам перезвоним. Нажала. Жду. ШАХРАЇ'
            ],
            [
                false,
                'Якийсь виграш, 370 тисяч....ще й набирають на корпоративний номер'
            ],
        ];
    }

}