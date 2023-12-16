<?php

declare(strict_types=1);

namespace App\Core\Providers;

class KZProvider extends AbstractProvider implements ProviderInterface
{
    public const NAME = 'ktozvonil.net';

    public function enable(): bool
    {
        return (bool)\env('KZ_SEARCH_PROVIDER');
    }
}
