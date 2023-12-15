<?php

declare(strict_types=1);

namespace App\Helpers\IgnoreMessage;

class AbstractIgnoreMessage implements IgnoreMessageInterface
{
    public function getList(): array
    {
        return [];
    }
}
