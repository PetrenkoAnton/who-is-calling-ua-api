<?php

declare(strict_types=1);

namespace App\Core\Parsers;

class KCParser extends AbstractParser implements ParserInterface
{
    public function getExpression(): string
    {
        return '.comments .content';
    }
}
