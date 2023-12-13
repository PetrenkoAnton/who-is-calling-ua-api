<?php

declare(strict_types=1);

namespace App\Helpers;

class TDCommentFormatter implements CommentFormatterInterface
{
    public function getExpression(): string
    {
        return '.comment-item .comment .comment-text';
    }

    public function format(string $comment): string
    {
        return $comment;
    }
}
