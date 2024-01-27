<?php

declare(strict_types=1);

namespace App\Core\IgnoreComments;

class CFIgnoreComment implements IgnoreCommentInterface
{
    /**
     * @return array<string>
     */
    public function getList(): array
    {
        return [
            'Цей відгук прихований модератором. Причина:',
        ];
    }
}
