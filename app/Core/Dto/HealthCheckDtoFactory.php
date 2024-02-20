<?php

declare(strict_types=1);

namespace App\Core\Dto;

class HealthCheckDtoFactory
{
    /**
     * @param array{data: array{health-check: 'fail'|'success'}, status: 200|500} $data
     */
    public function create(array $data): HealthCheckDto
    {
        return new HealthCheckDto($data);
    }
}
