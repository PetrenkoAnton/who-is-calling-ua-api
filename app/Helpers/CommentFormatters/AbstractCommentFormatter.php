<?php

declare(strict_types=1);

namespace App\Helpers\CommentFormatters;

use App\Helpers\IgnoreMessage\IgnoreMessageInterface;

abstract class AbstractCommentFormatter implements CommentFormatterInterface
{
    public function __construct(protected IgnoreMessageInterface $ignoreMessage)
    {
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
