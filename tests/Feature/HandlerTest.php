<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\Support\VersionRenameHelper;
use Tests\TestCase;

class HandlerTest extends TestCase
{
    /**
     * @group ok
     */
    public function testRender(): void
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

        VersionRenameHelper::rollback();
    }
}
