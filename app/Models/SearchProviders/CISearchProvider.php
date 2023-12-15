<?php

declare(strict_types=1);

namespace App\Models\SearchProviders;

use function env;

class CISearchProvider extends AbstractSearchProvider implements SearchProviderInterface
{
    public const NAME = 'callinsider.com.ua';

    public function enable(): bool
    {
        return (bool)env('CI_SEARCH_PROVIDER');
    }
}
