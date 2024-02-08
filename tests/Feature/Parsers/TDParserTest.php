<?php

declare(strict_types=1);

namespace Tests\Feature\Parsers;

use App\Core\Parsers\TDParser;
use App\Core\ProviderEnum;
use Tests\TestCase;

class TDParserTest extends TestCase
{
    private TDParser $parser;

    public function setUp(): void
    {
        parent::setUp();
        $this->parser = $this->app->make(TDParser::class);
    }

    /**
     * @group ok
     */
    public function testGetCommentsExpression(): void
    {
        $this->assertEquals('.comment-item .comment .comment-text', $this->parser->getCommentsExpression());
    }

    /**
     * @group ok
     */
    public function testGetIgnoreCommentsList(): void
    {
        $list = [
            'Повідомлення від адміністратора сайту telefonnyjdovidnyk.com.ua',
            'про цей номер телефону можна знайти на сайті партнера:',
            'Цей коментар був на прохання тимчасово видалений.',
        ];

        $this->assertEquals($list, $this->parser->getIgnoreCommentsList());
    }

    /**
     * @group ok
     */
    public function testFor(): void
    {
        $this->assertTrue($this->parser->for(ProviderEnum::TD));
    }

    /**
     * @group ok
     * @dataProvider dp
     */
    public function testFormat(string $expected, string $raw): void
    {
        $this->assertEquals($expected, $this->parser->format($raw));
    }

    public static function dp(): array
    {
        return [
            [
                'Шахраї !  Не беріть з цього номеру. Краще в спам одразу ж відправляти !',
                'Шахраї !  Не беріть з цього номеру. Краще в спам одразу ж відправляти !',
            ],
        ];
    }

    /**
     * @group ok
     * @dataProvider dpIgnore
     */
    public function testIgnore(string $comment): void
    {
        $this->assertTrue($this->parser->ignore($comment));
    }

    public static function dpIgnore(): array
    {
        return [
            // @codingStandardsIgnoreStart
            [
                'Повідомлення від адміністратора сайту telefonnyjdovidnyk.com.ua  «Допоможіть іншим відвідувачам сайту тим, що поділитеся з ними своїм досвідом спілкування з цим абонентом. Коли Вам з цього номеру телефонували і як часто? Що було предметом розмови, якщо Ви підняли трубку? Коментар, який Ви відіслали, буде показаний на цьому сайті.»  ',
            ],
            [
                'Інші коментарі про цей номер телефону можна знайти на сайті партнера: www.cejnomer.ru  (2×)',
            ],
            [
                'Інші коментарі про цей номер телефону можна знайти на сайті партнера: www.spravocnik.ru  (1×)',
            ],
            [
                'Інші коментарі про цей номер телефону можна знайти на сайті партнера: www.najtinomer.ru  (1×)',
            ],
            [
                'Інші коментарі про цей номер телефону можна знайти на сайті партнера: www.callinsider.com.ua  (6×)',
            ],
            [
                'Коментар про цей номер телефону можна знайти на сайті партнера: www.cejnomer.ru  (1×)',
            ],
            [
                'Коментар про цей номер телефону можна знайти на сайті партнера: www.callinsider.com.ua  (1×)',
            ],
            [
                'Цей коментар був на прохання тимчасово видалений. Модератори будуть розглядати цей запит якомога швидше.',
            ],
            // @codingStandardsIgnoreEnd
        ];
    }
}
