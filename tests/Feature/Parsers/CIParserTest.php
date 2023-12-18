<?php

declare(strict_types=1);

namespace Tests\Feature\Parsers;

use App\Core\Parsers\CIParser;
use Tests\TestCase;

class CIParserTest extends TestCase
{
    private CIParser $commentFormatter;

    public function setUp(): void
    {
        parent::setUp();
        $this->commentFormatter = $this->app->make(CIParser::class);
    }

    /**
     * @group ok
     */
    public function testGetExpression()
    {
        $this->assertEquals('.comment .summary p', $this->commentFormatter->getExpression());
    }

    /**
     * @group ok
     * @dataProvider dp
     */
    public function testFormat(string $expected, string $raw)
    {
        $this->assertEquals($expected, $this->commentFormatter->format($raw));
    }

    public static function dp(): array
    {
        return [
            [
                'На території України перевізник без попередження зупинився на 3 години (!), щоб зробити пересадку пасажирів з інших рейсів, вночі. При цьому, на сайті про такий маршрут не зазначалось.',
                "На території України перевізник без попередження зупинився на 3 години (!), щоб зробити пересадку пасажирів з інших рейсів, вночі. При цьому, на сайті про такий маршрут не зазначалось."
            ],
        ];
    }

    /**
     * @group ok
     * @dataProvider dpIgnore
     */
    public function testIgnore(bool $expected, string $comment)
    {
        $this->assertEquals($expected, $this->commentFormatter->ignore($comment));
    }

    public static function dpIgnore(): array
    {
        return [
            [
                true,
                'Цей коментар був на прохання тимчасово видалений. Модератори будуть розглядати цей запит якомога швидше.',
            ],
        ];
    }

}
