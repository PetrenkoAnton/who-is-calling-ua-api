<?php

declare(strict_types=1);

namespace App\Core\Parsers;

class CIParser extends AbstractParser implements ParserInterface
{
    public function getExpression(): string
    {
        return '.comment .summary p';
    }
}
