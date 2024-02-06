<?php

declare(strict_types=1);

namespace Tests\Feature\Parsers;

use App\Core\Parsers\KZParser;
use Tests\TestCase;

class KZParserTest extends TestCase
{
    private KZParser $commentFormatter;

    public function setUp(): void
    {
        parent::setUp();
        $this->commentFormatter = $this->app->make(KZParser::class);
    }

    /**
     * @group ok
     */
    public function testGetCommentsExpression(): void
    {
        $this->assertEquals('.comments .content', $this->commentFormatter->getCommentsExpression());
    }

    /**
     * @group ok
     * @dataProvider dp
     */
    public function testFormat(string $expected, string $raw): void
    {
        $this->assertEquals($expected, $this->commentFormatter->format($raw));
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
