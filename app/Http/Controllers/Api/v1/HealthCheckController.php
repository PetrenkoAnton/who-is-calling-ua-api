<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Core\Services\HealthCheckService;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

/**
 * @codeCoverageIgnore
 */
class HealthCheckController extends Controller
{
    public function __construct(private readonly HealthCheckService $service)
    {
    }

    public function check(): Response
    {
        $status = $this->service->check() ? BaseResponse::HTTP_OK : BaseResponse::HTTP_INTERNAL_SERVER_ERROR;

        return new Response('', $status);
    }
}
