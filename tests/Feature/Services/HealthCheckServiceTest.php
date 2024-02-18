<?php

declare(strict_types=1);

namespace Tests\Feature\Services;

use App\Core\Services\HealthCheckService;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

use function time;

class HealthCheckServiceTest extends TestCase
{
    private HealthCheckService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = $this->app->make(HealthCheckService::class);
    }

    /**
     * @group ok
     */
    public function testCheckSuccess(): void
    {
        $this->assertEquals(['health-check' => 'success'], $this->service->getData());
        $this->assertTrue($this->service->status());
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

        $this->assertEquals(['health-check' => 'success'], $this->service->getData());
        $this->assertFalse($this->service->status());
    }
}
