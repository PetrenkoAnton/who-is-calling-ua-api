<?php

declare(strict_types=1);

namespace App\Core\IgnoreComments;

class TDIgnoreComment implements IgnoreCommentInterface
{
    public function getList(): array
    {
        return [
            'Повідомлення від адміністратора сайту telefonnyjdovidnyk.com.ua',
            'про цей номер телефону можна знайти на сайті партнера:',
            'Цей коментар був на прохання тимчасово видалений.',
        ];
    }
}
