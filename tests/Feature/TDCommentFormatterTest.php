<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Helpers\TDCommentFormatter;
use Tests\TestCase;

class TDCommentFormatterTest extends TestCase
{
    private TDCommentFormatter $commentFormatter;

    public function setUp(): void
    {
        $this->commentFormatter = new TDCommentFormatter();
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
                "Шахраї !  Не беріть з цього номеру. Краще в спам одразу ж відправляти !"
            ],
        ];
    }

}
