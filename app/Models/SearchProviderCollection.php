<?php

declare(strict_types=1);

namespace App\Models;

class SearchProviderCollection extends Collection
{
    public function __construct(array $items = [])
    {
        parent::__construct(SearchProviderInterface::class, $items);
    }
}
