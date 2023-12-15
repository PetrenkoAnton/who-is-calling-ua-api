<?php

declare(strict_types=1);

namespace App\Core\CommentHandlers;

interface CommentHandlerInterface
{
    public function getExpression(): string;

    public function format(string $comment): string;

    public function ignore(string $comment): bool;
}
