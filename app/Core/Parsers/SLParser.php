<?php

declare(strict_types=1);

namespace App\Core\Parsers;

use App\Core\ProviderEnum;

class SLParser extends AbstractParser implements ParserInterface
{
    public function getCommentsExpression(): string
    {
        return '.comment .content p';
    }

    public function for(ProviderEnum $provider): bool
    {
        return $provider === ProviderEnum::SL;
    }
}
