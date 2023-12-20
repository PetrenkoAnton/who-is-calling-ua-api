<?php

declare(strict_types=1);

namespace App\Core\CommentsService;

interface CommentsServiceInterface
{
    public function addComment(string $comment): void;

    public function addComments(array $comments): void;

    public function getUniqueComments(): array;
}
