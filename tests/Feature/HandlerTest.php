<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class HandlerTest extends TestCase
{
    private const VERSION_RENAME = 'VERSION_RENAME';
    private const PATH = __DIR__ . '/../../';

    public function tearDown(): void
    {
        parent::tearDown();

        if (realpath(self::PATH . self::VERSION_RENAME)) {
            rename(realpath(self::PATH . self::VERSION_RENAME), 'VERSION');
        }
    }

    /**
     * @group ok
     */
    public function testRender(): void
    {
        $response = $this->get(route('v1/info'))->response;
        $response->assertOk();

        $path = realpath(self::PATH . 'VERSION');
        $path ? rename($path, self::VERSION_RENAME) : $this->fail('No VERSION file');

        $response = $this->get(route('v1/info'))->response;
        $response->assertInternalServerError();

        $response->assertJson(
            [
                'error' => 'VERSION file not found',
                'code' => 500,
            ],
        );
    }
}
