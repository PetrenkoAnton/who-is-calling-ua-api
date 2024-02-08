<?php

declare(strict_types=1);

namespace App\Core\Parsers;

use App\Core\ProviderEnum;
use Collection\Collectable;

interface ParserInterface extends Collectable
{
    public function for(ProviderEnum $provider): bool;

    public function getCommentsExpression(): string;

    public function format(string $comment): string;

    public function ignore(string $comment): bool;

    /**
     * @return array<string>
     */
    public function getIgnoreCommentsList(): array;
}
