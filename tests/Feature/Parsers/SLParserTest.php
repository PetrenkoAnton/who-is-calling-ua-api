<?php

declare(strict_types=1);

namespace Tests\Feature\Parsers;

use App\Core\Parsers\SLParser;
use App\Core\ProviderEnum;
use Tests\TestCase;

class SLParserTest extends TestCase
{
    private SLParser $parser;

    public function setUp(): void
    {
        parent::setUp();
        $this->parser = $this->app->make(SLParser::class);
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

    /**
     * @group ok
     */
    public function testFor(): void
    {
        $this->assertTrue($this->parser->for(ProviderEnum::SL));
    }
}
