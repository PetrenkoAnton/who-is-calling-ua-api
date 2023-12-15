<?php

declare(strict_types=1);

namespace App\Core\CommentHandlers;

class CICommentHandler extends AbstractCommentHandler implements CommentHandlerInterface
{
    public function getExpression(): string
    {
        return '.comment .summary p';
    }
}
