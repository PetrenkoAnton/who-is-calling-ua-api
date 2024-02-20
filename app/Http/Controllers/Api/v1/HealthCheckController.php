<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Core\Services\HealthCheckService;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller;

/**
 * @codeCoverageIgnore
 */
class HealthCheckController extends Controller
{
    public function __construct(private readonly HealthCheckService $service)
    {
    }

    public function check(): JsonResponse
    {
        $dto = $this->service->getHealthCheckDto();

        return new JsonResponse(
            data: $dto->getData(),
            status: $dto->getStatus(),
        );
    }
}
