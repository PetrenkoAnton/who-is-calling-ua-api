<?php

declare(strict_types=1);

namespace App\Core\IgnoreComments;

class CFIgnoreComment implements IgnoreCommentInterface
{
    public function getList(): array
    {
        return [
            'Цей відгук прихований модератором. Причина:',
        ];
    }
}
