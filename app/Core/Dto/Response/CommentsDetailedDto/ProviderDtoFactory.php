<?php

declare(strict_types=1);

namespace App\Core\Dto\Response\CommentsDetailedDto;

class ProviderDtoFactory
{
    public function create(array $data): ProviderDto
    {
        return new ProviderDto($data);
    }
}
