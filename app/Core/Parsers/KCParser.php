<?php

declare(strict_types=1);

namespace App\Core\Parsers;

use App\Core\ProviderEnum;

class KCParser extends AbstractParser implements ParserInterface
{
    public function getCommentsExpression(): string
    {
        return '.item .body';
    }

    public function for(ProviderEnum $provider): bool
    {
        return $provider === ProviderEnum::KC;
    }
}
