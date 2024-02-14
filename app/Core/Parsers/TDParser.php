<?php

declare(strict_types=1);

namespace App\Core\Parsers;

class TDParser extends AbstractParser implements ParserInterface
{
    public function getCommentsExpression(): string
    {
        return '.comment-item .comment .comment-text';
    }

    /**
     * @return array<string>
     */
    public function getIgnoreCommentsList(): array
    {
        return [
            'Повідомлення від адміністратора сайту telefonnyjdovidnyk.com.ua',
            'про цей номер телефону можна знайти на сайті партнера:',
            'Цей коментар був на прохання тимчасово видалений.',
        ];
    }
}
