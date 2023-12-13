<?php

declare(strict_types=1);

namespace App\Models;

class SearchProviderCollection extends Collection
{
    public function __construct(array $items = [])
    {
        parent::__construct(SearchProviderInterface::class, $items);
    }

    public function getEnabled(): SearchProviderCollection|Collection
    {
        return $this->filter(static function (SearchProviderInterface $searchProvider) {
            return $searchProvider->enable();
        });
    }
}
