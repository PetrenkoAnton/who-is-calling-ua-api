<?php

declare(strict_types=1);

namespace App\Core\Providers;

class CIProvider extends AbstractProvider implements ProviderInterface
{
    public const NAME = 'callinsider.com.ua';

    public function enable(): bool
    {
        return (bool)\env('CI_SEARCH_PROVIDER');
    }
}
