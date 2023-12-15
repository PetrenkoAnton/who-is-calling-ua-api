<?php

declare(strict_types=1);

namespace App\Core\CommentHandlers;

class TDCommentHandler extends AbstractCommentHandler implements CommentHandlerInterface
{
    public function getExpression(): string
    {
        return '.comment-item .comment .comment-text';
    }
}
