<?php

declare(strict_types=1);

namespace Tests\Feature\Parsers;

use App\Core\Parsers\SLParser;
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
    public function testGetExpression()
    {
        $this->assertEquals('.comment .content p', $this->parser->getExpression());
    }
}
