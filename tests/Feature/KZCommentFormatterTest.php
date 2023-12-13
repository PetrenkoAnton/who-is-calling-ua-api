<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Helpers\KZCommentFormatter;
use Tests\TestCase;

class CommentFormatterTest extends TestCase
{
    /**
     * @group ok
     * @dataProvider dataProvider
     */
    public function testKZformat(string $expected, string $raw)
    {
        $commentFormatter = new KZCommentFormatter();
        $this->assertEquals($expected, $commentFormatter->format($raw));
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
