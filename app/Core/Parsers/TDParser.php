<?php

declare(strict_types=1);

namespace App\Core\Parsers;

use App\Core\ProviderEnum;

class TDParser extends AbstractParser implements ParserInterface
{
    public function getExpression(): string
    {
        return '.comment-item .comment .comment-text';
    }

    public function for(ProviderEnum $provider): bool
    {
        return $provider === ProviderEnum::TD;
    }
}
