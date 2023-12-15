<?php

declare(strict_types=1);

namespace App\Helpers;

class KZCommentFormatter extends AbstractCommentFormatter implements CommentFormatterInterface
{
    public function getExpression(): string
    {
        return '.comments .content';
    }
}
