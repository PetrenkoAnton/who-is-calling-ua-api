<?php

declare(strict_types=1);

namespace App\Helpers\IgnoreMessage;

class CIIgnoreMessage implements IgnoreMessageInterface
{
    public function getList(): array
    {
        return [
            'Цей коментар був на прохання тимчасово видалений',
        ];
    }
}
