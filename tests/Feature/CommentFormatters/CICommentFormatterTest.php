<?php
declare(strict_types=1);

namespace Tests\Feature\CommentFormatters;

use App\Core\CommentHandlers\CICommentHandler;
use Tests\TestCase;

class CICommentFormatterTest extends TestCase
{
    private CICommentHandler $commentFormatter;

    public function setUp(): void
    {
        parent::setUp();
        $this->commentFormatter = $this->app->make(CICommentHandler::class);
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
                'На території України перевізник без попередження зупинився на 3 години (!), щоб зробити пересадку пасажирів з інших рейсів, вночі. При цьому, на сайті про такий маршрут не зазначалось.',
                "На території України перевізник без попередження зупинився на 3 години (!), щоб зробити пересадку пасажирів з інших рейсів, вночі. При цьому, на сайті про такий маршрут не зазначалось."
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
                'Цей коментар був на прохання тимчасово видалений. Модератори будуть розглядати цей запит якомога швидше.',
            ],
        ];
    }

}
