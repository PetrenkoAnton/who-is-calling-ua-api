<?php

declare(strict_types=1);

namespace App\Core\Parsers;

use App\Core\ProviderEnum;

class SLParser extends AbstractParser implements ParserInterface
{
    public function getExpression(): string
    {
        return '.comment .content p';
    }

    public function is(ProviderEnum $provider): bool
    {
        return $provider === ProviderEnum::SL;
    }
}
