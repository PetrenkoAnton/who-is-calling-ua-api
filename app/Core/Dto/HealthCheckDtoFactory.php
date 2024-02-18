<?php

declare(strict_types=1);

namespace App\Core\Dto;

class HealthCheckDtoFactory
{
    public function create(array $data): HealthCheckDto
    {
        return new HealthCheckDto($data);
    }
}
