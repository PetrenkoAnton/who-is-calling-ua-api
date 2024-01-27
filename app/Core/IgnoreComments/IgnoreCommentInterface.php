<?php

declare(strict_types=1);

namespace App\Core\IgnoreComments;

interface IgnoreCommentInterface
{
    /**
     * @return array<string>
     */
    public function getList(): array;
}
