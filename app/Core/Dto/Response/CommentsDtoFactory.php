<?php

declare(strict_types=1);

namespace App\Core\Dto\Response;

class CommentsDtoFactory
{
    /**
     * @param array{pn: string, cache: bool, comments: string[]} $data
     */
    public function create(array $data): CommentsDto
    {
        return new CommentsDto($data);
    }
}
