<?php

declare(strict_types=1);

namespace Tests\Feature\Http;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class HealthCheckTest extends TestCase
{
    /**
     * @group ok
     */
    public function testTheApplicationReturnsASuccessfulResponse()
    {
        $this->get('/')->seeStatusCode(Response::HTTP_OK);

        $this->assertEquals(
            $this->app->version(),
            $this->response->getContent()
        );
    }

    /**
     * @group ok
     */
    public function testHealthCheckEndpointReturnsASuccessfulResponse()
    {
        $this->get(route('healthCheck'))->seeStatusCode(Response::HTTP_OK);
    }
}
