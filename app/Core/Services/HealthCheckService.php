<?php

declare(strict_types=1);

namespace App\Core\Services;

use App\Core\Dto\Response\HealthCheckDto;
use App\Core\Dto\Response\HealthCheckDtoFactory;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

use function time;

class HealthCheckService
{
    public const KEY = 'health-check';

    public function __construct(private readonly HealthCheckDtoFactory $dtoFactory)
    {
    }

    public function getHealthCheckDto(): HealthCheckDto
    {
        $status = $this->status();

        $data = [
            'data' => [
                self::KEY => $status ? 'success' : 'fail',
            ],
            'status' => $status ? BaseResponse::HTTP_OK : BaseResponse::HTTP_INTERNAL_SERVER_ERROR,
        ];

        return $this->dtoFactory->create($data);
    }

    private function status(): bool
    {
        return $this->checkCache();
    }

    private function checkCache(): bool
    {
        $input = time();

        Cache::put(self::KEY, $input);

        return $input === (int) Cache::pull(self::KEY);
    }
}
