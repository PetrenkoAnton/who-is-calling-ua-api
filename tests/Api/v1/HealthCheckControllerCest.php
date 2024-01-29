<?php

declare(strict_types=1);

namespace Tests\Api\v1;

use Tests\Support\ApiTester;

class HealthCheckControllerCest
{
    /**
     * @param ApiTester $I
     * @group smoke
     */
    public function getHealthCheck(ApiTester $I): void
    {
        $I->sendGet('/v1/health-check');
        $I->seeResponseCodeIs(200);
    }
}
