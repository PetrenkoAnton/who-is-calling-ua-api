<?php

declare(strict_types=1);

namespace Tests\Feature\Parsers;

use App\Core\Parsers\CIParser;
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
}
