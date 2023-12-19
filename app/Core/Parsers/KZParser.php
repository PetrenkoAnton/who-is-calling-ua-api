<?php

declare(strict_types=1);

namespace App\Core\Parsers;

use App\Core\ProviderEnum;

class KZParser extends AbstractParser implements ParserInterface
{
    public function getExpression(): string
    {
        return '.comments .content';
    }

    public function for(ProviderEnum $provider): bool
    {
        return $provider === ProviderEnum::KZ;
    }
}
