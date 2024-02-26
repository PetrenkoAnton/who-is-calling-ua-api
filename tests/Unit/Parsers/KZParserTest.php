<?php

declare(strict_types=1);

namespace Tests\Unit\Parsers;

use App\Core\Parsers\KZParser;
use PHPUnit\Framework\TestCase;

class KZParserTest extends TestCase
{
    private KZParser $parser;

    public function setUp(): void
    {
        $this->parser = new KZParser();
    }

    /**
     * @group ok
     */
    public function testGetCommentsExpression(): void
    {
        $this->assertEquals('.comments .content', $this->parser->getCommentsExpression());
    }

    /**
     * @group ok
     */
    public function testGetIgnoreCommentsList(): void
    {
        $list = [];

        $this->assertEquals($list, $this->parser->getIgnoreCommentsList());
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
                // @codingStandardsIgnoreStart
                'Шахраї !  Не беріть з цього номеру. Краще в спам одразу ж відправляти !',
                "\n
                                                                        Шахраї !  Не беріть з цього номеру. Краще в спам одразу ж відправляти !"
                // @codingStandardsIgnoreEnd
            ],
        ];
    }
}
