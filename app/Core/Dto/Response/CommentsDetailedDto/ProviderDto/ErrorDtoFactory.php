<?php

declare(strict_types=1);

namespace App\Core\Dto\Response\CommentsDetailedDto\ProviderDto;

class ErrorDtoFactory
{
    public function create(array $data): ErrorDto
    {
        return new ErrorDto($data);
    }
}
