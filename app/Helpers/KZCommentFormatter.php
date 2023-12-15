<?php

declare(strict_types=1);

namespace App\Helpers;

class KZCommentFormatter implements CommentFormatterInterface
{
    public function getExpression(): string
    {
        return '.comments .content';
    }

    public function format(string $comment): string
    {
        return \trim(\str_replace("\n", ' ', $comment));
    }

    public function ignore(string $comment): bool
    {
        return false;
    }
}
