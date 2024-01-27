<?php

declare(strict_types=1);

namespace App\Core\IgnoreComments;

class AbstractIgnoreComment implements IgnoreCommentInterface
{
    /**
     * @return array{}
     */
    public function getList(): array
    {
        return [];
    }
}
