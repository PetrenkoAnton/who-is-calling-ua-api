<?php

declare(strict_types=1);

namespace App\Core\Parsers;

class CFParser extends AbstractParser implements ParserInterface
{
    public function getExpression(): string
    {
        return '.review .review_comment';
    }
}
