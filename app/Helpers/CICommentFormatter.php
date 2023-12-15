<?php

declare(strict_types=1);

namespace App\Helpers;

class CICommentFormatter extends AbstractCommentFormatter implements CommentFormatterInterface
{
    public function getExpression(): string
    {
        return '.comment .summary p';
    }
}
