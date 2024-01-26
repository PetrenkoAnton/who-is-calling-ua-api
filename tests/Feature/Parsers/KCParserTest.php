<?php

declare(strict_types=1);

namespace Tests\Feature\Parsers;

use App\Core\Parsers\KCParser;
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
    public function testGetExpression(): void
    {
        $this->assertEquals('.item .body', $this->parser->getExpression());
    }
}
