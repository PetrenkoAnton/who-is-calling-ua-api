<?php

declare(strict_types=1);

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * @var array<string>
     */
    protected array $listen = [];

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
