<?php

declare(strict_types=1);

namespace Tests\Feature\Parsers;

use App\Core\Parsers\KZParser;
use App\Core\ProviderEnum;
use Tests\TestCase;

class KZParserTest extends TestCase
{
    private KZParser $parser;

    public function setUp(): void
    {
        parent::setUp();
        $this->parser = $this->app->make(KZParser::class);
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
     */
    public function testFor(): void
    {
        $this->assertTrue($this->parser->for(ProviderEnum::KZ));
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
