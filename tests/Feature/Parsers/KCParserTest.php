<?php

declare(strict_types=1);

namespace Tests\Feature\Parsers;

use App\Core\Parsers\KCParser;
use App\Core\ProviderEnum;
use Tests\TestCase;

class KCParserTest extends TestCase
{
    private KCParser $parser;

    public function setUp(): void
    {
        parent::setUp();
        $this->parser = $this->app->make(KCParser::class);
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

    /**
     * @group ok
     */
    public function testFor(): void
    {
        $this->assertTrue($this->parser->for(ProviderEnum::KC));
    }
}
