<?php

declare(strict_types=1);

namespace App\Core\HttpClient\UserAgent;

use App\Core\Collection;

class UserAgentCollection extends Collection
{
    public function __construct(UserAgentInterface ...$items)
    {
        $this->items = $items;
    }
}
