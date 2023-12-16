<?php

declare(strict_types=1);

namespace App\Core\Parsers;

class TDParser extends AbstractParser implements ParserInterface
{
    public function getExpression(): string
    {
        return '.comment-item .comment .comment-text';
    }
}
