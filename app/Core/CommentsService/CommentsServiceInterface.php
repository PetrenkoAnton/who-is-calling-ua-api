<?php

declare(strict_types=1);

namespace App\Core\CommentsService;

interface CommentsServiceInterface
{
    public function addComment(string $comment): void;

    /**
     * @param array<string> $comments
     */
    public function addComments(array $comments): void;

    /**
     * @return array<string>
     */
    public function getUniqueComments(): array;
}
