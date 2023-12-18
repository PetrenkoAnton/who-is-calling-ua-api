<?php

declare(strict_types=1);

namespace App\Core\Providers;

class KCProvider extends AbstractProvider implements ProviderInterface
{
    public const NAME = 'kto-zvonil.com.ua/';

    public function enable(): bool
    {
        return (bool)\env('KC_SEARCH_PROVIDER');
    }
}
