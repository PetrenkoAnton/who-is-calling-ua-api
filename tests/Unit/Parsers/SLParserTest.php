<?php

declare(strict_types=1);

namespace Tests\Unit\Parsers;

use App\Core\Parsers\SLParser;
use PHPUnit\Framework\TestCase;

class SLParserTest extends TestCase
{
    private SLParser $parser;

    public function setUp(): void
    {
        $this->parser = new SLParser();
    }

    /**
     * @group ok
     */
    public function testGetCommentsExpression(): void
    {
        $this->assertEquals('.comment .content p', $this->parser->getCommentsExpression());
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
