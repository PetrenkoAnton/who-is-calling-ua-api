<?php

declare(strict_types=1);

namespace Tests\Feature\Parsers;

use App\Core\Parsers\CIParser;
use App\Core\ProviderEnum;
use Tests\TestCase;

class CIParserTest extends TestCase
{
    private CIParser $parser;

    public function setUp(): void
    {
        parent::setUp();
        $this->parser = $this->app->make(CIParser::class);
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
     */
    public function testFor(): void
    {
        $this->assertTrue($this->parser->for(ProviderEnum::CI));
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
