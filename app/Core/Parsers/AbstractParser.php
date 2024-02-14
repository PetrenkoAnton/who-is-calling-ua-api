<?php

declare(strict_types=1);

namespace App\Core\Parsers;

use function str_contains;
use function str_replace;
use function trim;

abstract class AbstractParser implements ParserInterface
{
    abstract public function getCommentsExpression(): string;

    public function getIgnoreCommentsList(): array
    {
        return [];
    }

    public function format(string $comment): string
    {
        return trim(str_replace("\n", ' ', $comment));
    }

    public function ignore(string $comment): bool
    {
        if (!$this->getIgnoreCommentsList()) {
            return false;
        }

        $res = false;

        foreach ($this->getIgnoreCommentsList() as $ignoreMessage) {
            if (str_contains($comment, $ignoreMessage)) {
                $res = true;

                break;
            }
        }

        return $res;
    }
}
