<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\Dto\HealthCheckDto;
use App\Core\Dto\HealthCheckDtoFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

class HealthCheckDtoFactoryTest extends TestCase
{
    private HealthCheckDtoFactory $dtoFactory;

    public function setUp(): void
    {
        $this->dtoFactory = new HealthCheckDtoFactory();
    }

    /**
     * @group ok
     */
    public function testCreate(): void
    {
        $data = [
            'data' => [
                'health-check' => 'success',
            ],
            'status' => BaseResponse::HTTP_OK,
        ];

        $dto = $this->dtoFactory->create($data);

        $this->assertInstanceOf(HealthCheckDto::class, $dto);

        $this->assertEquals($data['data'], $dto->getData());
        $this->assertEquals(200, $dto->getStatus());
    }
}
