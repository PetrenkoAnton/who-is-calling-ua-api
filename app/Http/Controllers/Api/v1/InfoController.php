<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Core\Dto\InfoDto;
use App\Core\Services\InfoService;
use Laravel\Lumen\Routing\Controller;

/**
 * @codeCoverageIgnore
 */
class InfoController extends Controller
{
    public function __construct(private readonly InfoService $service)
    {
    }

    public function info(): InfoDto
    {
        return $this->service->getInfoDto();
    }
}
