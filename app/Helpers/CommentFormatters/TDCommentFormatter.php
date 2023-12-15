<?php

declare(strict_types=1);

namespace App\Helpers\CommentFormatters;

class TDCommentFormatter extends AbstractCommentFormatter implements CommentFormatterInterface
{
    public function getExpression(): string
    {
        return '.comment-item .comment .comment-text';
    }
}
