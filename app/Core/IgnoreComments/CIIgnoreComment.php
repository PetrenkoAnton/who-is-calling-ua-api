<?php

declare(strict_types=1);

namespace App\Core\IgnoreComments;

class CIIgnoreComment implements IgnoreCommentInterface
{
    public function getList(): array
    {
        return [
            'Цей коментар був на прохання тимчасово видалений',
        ];
    }
}