<?php
declare(strict_types=1);

namespace Tests\Feature\CommentFormatters;

use App\Core\CommentHandlers\KZCommentHandler;
use Tests\TestCase;

class KZCommentFormatterTest extends TestCase
{
    private KZCommentHandler $commentFormatter;

    public function setUp(): void
    {
        parent::setUp();
        $this->commentFormatter = $this->app->make(KZCommentHandler::class);
    }

    /**
     * @group ok
     */
    public function testGetExpression()
    {
        $this->assertEquals('.comments .content', $this->commentFormatter->getExpression());
    }

    /**
     * @group ok
     * @dataProvider dataProvider
     */
    public function testFormat(string $expected, string $raw)
    {
        $this->assertEquals($expected, $this->commentFormatter->format($raw));
    }

    public static function dataProvider(): array
    {
        return [
            [
                'Шахраї !  Не беріть з цього номеру. Краще в спам одразу ж відправляти !',
                "\n
                                                                        Шахраї !  Не беріть з цього номеру. Краще в спам одразу ж відправляти !"
            ],
        ];
    }

}
