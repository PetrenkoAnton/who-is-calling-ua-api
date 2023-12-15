<?php

declare(strict_types=1);

namespace App\Core\CommentHandlers;

class KZCommentHandler extends AbstractCommentHandler implements CommentHandlerInterface
{
    public function getExpression(): string
    {
        return '.comments .content';
    }
}
