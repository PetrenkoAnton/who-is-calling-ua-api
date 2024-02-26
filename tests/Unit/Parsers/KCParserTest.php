<?php

declare(strict_types=1);

namespace Tests\Unit\Parsers;

use App\Core\Parsers\KCParser;
use PHPUnit\Framework\TestCase;

class KCParserTest extends TestCase
{
    private KCParser $parser;

    public function setUp(): void
    {
        $this->parser = new KCParser();
    }

    /**
     * @group ok
     */
    public function testGetCommentsExpression(): void
    {
        $this->assertEquals('.item .body', $this->parser->getCommentsExpression());
    }

    /**
     * @group ok
     */
    public function testGetIgnoreCommentsList(): void
    {
        $list = [];

        $this->assertEquals($list, $this->parser->getIgnoreCommentsList());
    }
}
