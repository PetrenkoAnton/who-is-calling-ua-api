<?php

declare(strict_types=1);

namespace Tests\Unit\Parsers;

use App\Core\Parsers\CFParser;
use PHPUnit\Framework\TestCase;

class CFParserTest extends TestCase
{
    private CFParser $parser;

    public function setUp(): void
    {
        $this->parser = new CFParser();
    }

    /**
     * @group ok
     */
    public function testGetCommentsExpression(): void
    {
        $this->assertEquals('.review .review_comment', $this->parser->getCommentsExpression());
    }

    /**
     * @group ok
     */
    public function testGetIgnoreCommentsList(): void
    {
        $list = [
            'Цей відгук прихований модератором. Причина:',
        ];

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
                'Цей відгук прихований модератором. Причина: порушення правил сервісу. (програвалася запис / робот)',
            ],
            // @codingStandardsIgnoreEnd
        ];
    }
}
