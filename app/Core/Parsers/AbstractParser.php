<?php

declare(strict_types=1);

namespace App\Core\Parsers;

use App\Core\IgnoreComments\IgnoreCommentInterface;
use App\Core\ProviderEnum;

abstract class AbstractParser implements ParserInterface
{
    public function __construct(protected IgnoreCommentInterface $ignoreComment)
    {
    }

    abstract public function for(ProviderEnum $provider): bool;

    abstract public function getExpression(): string;

    public function format(string $comment): string
    {
        return \trim(\str_replace("\n", ' ', $comment));
    }

    public function ignore(string $comment): bool
    {
        if (!$this->ignoreComment->getList()) {
            return false;
        }

        $res = false;

        foreach ($this->ignoreComment->getList() as $ignoreMessage) {
            if (\str_contains($comment, $ignoreMessage)) {
                $res = true;
                break;
            }
        }

        return $res;
    }
}
