<?php

declare(strict_types=1);

namespace App\Core\Providers;

class TDProvider extends AbstractProvider implements ProviderInterface
{
    public const NAME = 'telefonnyjdovidnyk.com.ua';

    public function enable(): bool
    {
        return (bool)\env('TD_SEARCH_PROVIDER');
    }
}
