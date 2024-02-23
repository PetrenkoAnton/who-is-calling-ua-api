<?php

declare(strict_types=1);

namespace App\Core\Dto\Response\CommentsDetailedDto;

class ProviderDtoFactory
{
    /**
     * @param array{name: string, url: string, code: string, comments: string[], error: (array{message: string, code: integer})|null} $data
     */
    public function create(array $data): ProviderDto
    {
        return new ProviderDto($data);
    }
}
