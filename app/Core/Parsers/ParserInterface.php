<?php

declare(strict_types=1);

namespace App\Core\Parsers;

use App\Core\ProviderEnum;

interface ParserInterface
{
    public function for(ProviderEnum $provider): bool;

    public function getExpression(): string;

    public function format(string $comment): string;

    public function ignore(string $comment): bool;
}
