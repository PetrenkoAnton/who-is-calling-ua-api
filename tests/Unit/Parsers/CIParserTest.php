<?php

declare(strict_types=1);

namespace Tests\Unit\Parsers;

use App\Core\Parsers\CIParser;
use PHPUnit\Framework\TestCase;

class CIParserTest extends TestCase
{
    private CIParser $parser;

    public function setUp(): void
    {
        $this->parser = new CIParser();
    }

    /**
     * @group ok
     */
    public function testGetCommentsExpression(): void
    {
        $this->assertEquals('.comment .summary p', $this->parser->getCommentsExpression());
    }

    /**
     * @group ok
     */
    public function testGetIgnoreCommentsList(): void
    {
        $list = [
            'Цей коментар був на прохання тимчасово видалений',
        ];

        $this->assertEquals($list, $this->parser->getIgnoreCommentsList());
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
                'Цей коментар був на прохання тимчасово видалений. Модератори будуть розглядати цей запит якомога швидше.',
            ],
            // @codingStandardsIgnoreEnd
        ];
    }
}
