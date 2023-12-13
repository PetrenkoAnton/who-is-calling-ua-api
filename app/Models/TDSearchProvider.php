<?php

declare(strict_types=1);

namespace App\Models;

class TDSearchProvider extends AbstractSearchProvider implements SearchProviderInterface
{
    public const NAME = 'telefonnyjdovidnyk.com.ua';

    public function enable(): bool
    {
        return (bool) env('TD_SEARCH_PROVIDER');
    }
}
