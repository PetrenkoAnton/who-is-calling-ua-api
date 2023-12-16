<?php

declare(strict_types=1);

namespace App\Core\CommentHandlers;

use App\Core\IgnoreComments\IgnoreCommentInterface;

abstract class AbstractCommentHandler implements CommentHandlerInterface
{
    public function __construct(protected IgnoreCommentInterface $ignoreMessage)
    {
    }

    public function getExpression(): string
    {
        return '';
    }

    public function format(string $comment): string
    {
        return \trim(\str_replace("\n", ' ', $comment));
    }

    public function ignore(string $comment): bool
    {
        if (!$this->ignoreMessage->getList()) {
            return false;
        }

        $res = false;

        foreach ($this->ignoreMessage->getList() as $ignoreMessage) {
            if (\str_contains($comment, $ignoreMessage)) {
                $res = true;
                break;
            }
        }

        return $res;
    }
}
