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
    public function testGetExpression()
    {
        $this->assertEquals('.comments .content', $this->commentFormatter->getExpression());
    }

    /**
     * @group ok
     * @dataProvider dp
     */
    public function testFormat(string $expected, string $raw)
    {
        $this->assertEquals($expected, $this->commentFormatter->format($raw));
    }

    public static function dp(): array
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
