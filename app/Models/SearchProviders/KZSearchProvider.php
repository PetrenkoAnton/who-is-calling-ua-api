<?php

declare(strict_types=1);

namespace App\Models\SearchProviders;

use function env;

class KZSearchProvider extends AbstractSearchProvider implements SearchProviderInterface
{
    public const NAME = 'ktozvonil.net';

    public function enable(): bool
    {
        return (bool)\env('KZ_SEARCH_PROVIDER');
    }
}
