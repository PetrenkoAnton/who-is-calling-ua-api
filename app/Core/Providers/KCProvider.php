<?php

declare(strict_types=1);

namespace App\Core\Providers;

use App\Core\ProviderEnum;

class KCProvider extends AbstractProvider implements ProviderInterface
{
    public function getEnum(): ProviderEnum
    {
        return ProviderEnum::KC;
    }
}
