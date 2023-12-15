<?php

declare(strict_types=1);

namespace App\Helpers;

class TDCommentFormatter implements CommentFormatterInterface
{
    public function getExpression(): string
    {
        return '.comment-item .comment .comment-text';
    }

    public function format(string $comment): string
    {
        return $comment;
    }

    public function ignore(string $comment): bool
    {
        $res = false;

        $ignoreMessages = [
            'Повідомлення від адміністратора сайту telefonnyjdovidnyk.com.ua',
            'про цей номер телефону можна знайти на сайті партнера:',
        ];

        foreach ($ignoreMessages as $ignoreMessage) {
            if (\str_contains($comment, $ignoreMessage)) {
                $res = true;
                break;
            }
        }

        return $res;
    }
}
