<?php

declare(strict_types=1);

namespace App\Core\Providers;

class SLProvider extends AbstractProvider implements ProviderInterface
{
    public const NAME = 'slick.ly';

    public function enable(): bool
    {
        return (bool)\env('SL_SEARCH_PROVIDER');
    }
}
