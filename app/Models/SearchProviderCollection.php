<?php

declare(strict_types=1);

namespace App\Models;

class SearchProviderCollection extends Collection
{
    public function __construct(SearchProviderInterface ...$items)
    {
        $this->items = $items;
    }

    public function getEnabled(): SearchProviderCollection
    {
        return $this->filter(static function (SearchProviderInterface $searchProvider) {
            return $searchProvider->enable();
        });
    }
}
