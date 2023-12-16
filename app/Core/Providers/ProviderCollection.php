<?php

declare(strict_types=1);

namespace App\Core\Providers;

use App\Core\Collection;

class ProviderCollection extends Collection
{
    public function __construct(ProviderInterface ...$items)
    {
        $this->items = $items;
    }

    public function getEnabled(): ProviderCollection
    {
        return $this->filter(static function (ProviderInterface $searchProvider) {
            return $searchProvider->enable();
        });
    }
}
