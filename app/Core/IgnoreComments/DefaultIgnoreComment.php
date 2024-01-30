<?php

declare(strict_types=1);

namespace App\Core\IgnoreComments;

class DefaultIgnoreComment implements IgnoreCommentInterface
{
    /**
     * @return array{}
     */
    public function getList(): array
    {
        return [];
    }
}
