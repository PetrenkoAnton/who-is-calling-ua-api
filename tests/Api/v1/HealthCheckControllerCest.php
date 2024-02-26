<?php

declare(strict_types=1);

namespace Tests\Api\v1;

use Tests\Support\ApiTester;

class HealthCheckControllerCest
{
    /**
     * @group smoke
     */
    public function getHealthCheck(ApiTester $apiTester): void
    {
        $apiTester->sendGet('/v1/health-check');
        $apiTester->seeResponseCodeIs(200);
    }
}
