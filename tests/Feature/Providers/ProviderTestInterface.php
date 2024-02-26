<?php

declare(strict_types=1);

namespace Tests\Feature\Providers;

interface ProviderTestInterface
{
    public function getProviderClass(): string;
}
