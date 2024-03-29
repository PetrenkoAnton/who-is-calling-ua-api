<?php

declare(strict_types=1);

namespace App\Core\Dto\Response;

use App\Core\Dto\Dto;

/**
 * @method array getData()
 * @method int getStatus()
 */
class HealthCheckDto extends Dto
{
    /**
     * @var array{health-check:string}
     */
    protected array $data;
    protected int $status;
}
