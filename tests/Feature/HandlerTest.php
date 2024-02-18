<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\Support\VersionRenameHelper;
use Tests\TestCase;

use function putenv;
use function route;

class HandlerTest extends TestCase
{
    /**
     * @group ok
     */
    public function testRender404(): void
    {
        $response = $this->get(route('v1/info') . '/invalid')->response;
        $response->assertNotFound();

        $response->assertJson(
            [
                'error' => 'Not found',
                'code' => 404,
            ],
        );
    }

    /**
     * @group ok
     */
    public function testRender422(): void
    {
        $response = $this->get(route('v1/search', ['pn' => 'aaa', 'c' => 'aaa']))->response;
        $response->assertUnprocessable();

        $response->assertJson(
            [
                'error' => [
                    'validation' => [
                        [
                            'attribute' => 'c',
                            'info' => 'The c field must be true or false.',
                        ],
                        [
                            'attribute' => 'pn',
                            'info' => 'Not numeric phone number',
                        ],
                    ],
                ],
                'code' => 422,
            ],
        );
    }

    /**
     * @group ok
     */
    public function testRender500(): void
    {
        $response = $this->get(route('v1/info'))->response;
        $response->assertOk();

        VersionRenameHelper::rename();

        $response = $this->get(route('v1/info'))->response;
        $response->assertInternalServerError();

        $response->assertJson(
            [
                'error' => 'VERSION file not found',
                'code' => 500,
            ],
        );

        putenv('APP_DEBUG=0');

        $response = $this->get(route('v1/info'))->response;
        $response->assertInternalServerError();

        $response->assertJson(
            [
                'error' => 'Internal server error',
                'code' => 500,
            ],
        );

        putenv('APP_DEBUG=1');

        $response = $this->get(route('v1/info'))->response;
        $response->assertInternalServerError();

        $response->assertJson(
            [
                'error' => 'VERSION file not found',
                'code' => 500,
            ],
        );

        VersionRenameHelper::rollback();
    }
}
