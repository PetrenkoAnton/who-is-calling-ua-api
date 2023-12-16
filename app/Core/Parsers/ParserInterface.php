<?php

declare(strict_types=1);

namespace App\Core\Parsers;

interface ParserInterface
{
    public function getExpression(): string;

    public function format(string $comment): string;

    public function ignore(string $comment): bool;
}
