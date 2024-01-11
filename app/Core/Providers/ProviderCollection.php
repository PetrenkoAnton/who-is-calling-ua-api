<?php

declare(strict_types=1);

namespace App\Core\Providers;

use Collection\Collection;

class ProviderCollection extends Collection
{
    public function __construct(ProviderInterface ...$items)
    {
        parent::__construct(... $items);
    }

    public function getEnabled(): ProviderCollection
    {
        return $this->filter(fn (ProviderInterface $searchProvider) => $searchProvider->enable());
    }
}
