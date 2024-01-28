<?php

declare(strict_types=1);

namespace App\Core\Parsers;

use App\Core\ProviderEnum;

class CIParser extends AbstractParser implements ParserInterface
{
    public function getCommentsExpression(): string
    {
        return '.comment .summary p';
    }

    public function for(ProviderEnum $provider): bool
    {
        return $provider === ProviderEnum::CI;
    }
}
