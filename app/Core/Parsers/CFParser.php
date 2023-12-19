<?php

declare(strict_types=1);

namespace App\Core\Parsers;

use App\Core\ProviderEnum;

class CFParser extends AbstractParser implements ParserInterface
{
    public function getExpression(): string
    {
        return '.review .review_comment';
    }

    public function for(ProviderEnum $provider): bool
    {
        return $provider === ProviderEnum::CF;
    }
}
