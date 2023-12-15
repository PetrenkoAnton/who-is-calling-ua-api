<?php

declare(strict_types=1);

namespace App\Core\IgnoreComments;

interface IgnoreCommentInterface
{
    public function getList(): array;
}
