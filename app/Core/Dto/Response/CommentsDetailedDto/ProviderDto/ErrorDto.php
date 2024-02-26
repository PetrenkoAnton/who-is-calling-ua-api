<?php

declare(strict_types=1);

namespace App\Core\Dto\Response\CommentsDetailedDto\ProviderDto;

use App\Core\Dto\Dto;

/**
 * @method string getMessage()
 * @method int getCode()
 */
class ErrorDto extends Dto
{
    protected string $message;
    protected int $code;
}
