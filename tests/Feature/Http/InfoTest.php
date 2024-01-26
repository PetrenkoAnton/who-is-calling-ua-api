<?php

declare(strict_types=1);

namespace Tests\Feature\Http;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class InfoTest extends TestCase
{
    /**
     * @group ok
     */
    public function testInfoEndpointReturnsASuccessfulResponse(): void
    {
        // TODO! Add more asserts
        $this
            ->get(route('v1/info'))
            ->seeStatusCode(Response::HTTP_OK);
    }
}
