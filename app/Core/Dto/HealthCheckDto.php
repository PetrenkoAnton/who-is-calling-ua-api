<?php

namespace App\Core\Dto;

use Dto\Dto;

/**
 * @method array getData()
 * @method int getStatus()
 */
class HealthCheckDto extends Dto
{
    /**
     * @var array<'health-check', string>
     */
    protected array $data;
    protected int $status;
}
