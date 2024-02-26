<?php

declare(strict_types=1);

namespace Tests\Feature\Services;

use App\Core\Services\HealthCheckService;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

use function time;

class HealthCheckServiceTest extends TestCase
{
    /**
     * @group ok
     */
    public function testCheckSuccess(): void
    {
        $dto = $this->app->make(HealthCheckService::class)->getHealthCheckDto();

        $this->assertEquals(['health-check' => 'success'], $dto->getData());
        $this->assertEquals(200, $dto->getStatus());
    }

    /**
     * @group ok
     */
    public function testCheckFailed(): void
    {
        Cache::shouldReceive('put')
            ->once()
            ->with(HealthCheckService::KEY, time())
            ->andReturn(true);

        Cache::shouldReceive('pull')
            ->once()
            ->with(HealthCheckService::KEY)
            ->andReturn(0);

        $dto = $this->app->make(HealthCheckService::class)->getHealthCheckDto();

        $this->assertEquals(['health-check' => 'fail'], $dto->getData());
        $this->assertEquals(500, $dto->getStatus());
    }
}
