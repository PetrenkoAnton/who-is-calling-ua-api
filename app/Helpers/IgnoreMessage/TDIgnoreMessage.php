<?php

declare(strict_types=1);

namespace App\Helpers\IgnoreMessage;

class TDIgnoreMessage implements IgnoreMessageInterface
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
