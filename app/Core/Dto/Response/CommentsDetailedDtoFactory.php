<?php

declare(strict_types=1);

namespace App\Core\Dto\Response;

class CommentsDetailedDtoFactory
{
    public function create(array $data): CommentsDetailedDto
    {
        return new CommentsDetailedDto($data);
    }
}
