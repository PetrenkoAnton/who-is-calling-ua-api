<?php

declare(strict_types=1);

namespace App\Core\CommentsService;

use function array_unique;
use function array_values;

class CommentsService implements CommentsServiceInterface
{
    /**
     * @var array<string>
     */
    private array $comments;

    public function __construct(string ...$comments)
    {
        $this->comments = $comments;
    }

    public function addComment(string $comment): void
    {
        $this->comments[] = $comment;
    }

    /**
     * @param array<string> $comments
     */
    public function addComments(array $comments): void
    {
        foreach ($comments as $comment) {
            $this->addComment($comment);
        }
    }

    /**
     * @return array<string>
     */
    public function getUniqueComments(): array
    {
        return array_values(array_unique($this->comments));
    }
}
