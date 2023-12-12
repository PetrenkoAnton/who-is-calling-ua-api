<?php

declare(strict_types=1);

namespace App\Helpers;

class CommentFormatter
{
    public function kzformat(string $comment): string
    {
        return \trim(\str_replace("\n", ' ', $comment));
    }
}
