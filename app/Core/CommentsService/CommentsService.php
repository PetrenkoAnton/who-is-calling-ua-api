<?php

declare(strict_types=1);

namespace App\Core\CommentsService;

class CommentsService implements CommentsServiceInterface
{
    private array $comments;

    public function __construct(string ...$comments)
    {
        $this->comments = $comments;
    }

    public function addComment(string $comment): void
    {
        $this->comments[] = $comment;
    }

    public function addComments(array $comments): void
    {
        foreach ($comments as $comment) {
            $this->addComment($comment);
        }
    }

    public function getUniqueComments(): array
    {
        return \array_values(\array_unique($this->comments));
    }
}
