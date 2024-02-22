<?php

declare(strict_types=1);

namespace App\Core\Dto\Response;

class CommentsDtoFactory
{
    public function create(array $data): CommentsDto
    {
        return new CommentsDto($data);
    }
}
