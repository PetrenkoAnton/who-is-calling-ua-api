<?php

declare(strict_types=1);

namespace App\Core\Parsers;

interface ParserInterface
{
    public function getCommentsExpression(): string;

    public function format(string $comment): string;

    public function ignore(string $comment): bool;

    /**
     * @return array<string>
     */
    public function getIgnoreCommentsList(): array;
}
