<?php

declare(strict_types=1);

namespace App\Core\Dto\Response;

class CommentsDetailedDtoFactory
{
    /**
     * @param array{
     *      pn: string,
     *      comments: string[],
     *      providers: CommentsDetailedDto\ProviderDtoCollection|array{name: string, url: string, comments: string[], error: array{message: string, code: int}|null}[]
     * } $data
     */
    public function create(array $data): CommentsDetailedDto
    {
        return new CommentsDetailedDto($data);
    }
}
