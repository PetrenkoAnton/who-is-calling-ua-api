<?php

declare(strict_types=1);

namespace App\Core\Providers;

use App\Core\ProviderEnum;

class KZProvider extends AbstractProvider implements ProviderInterface
{
    public function getEnum(): ProviderEnum
    {
        return ProviderEnum::KZ;
    }
}
