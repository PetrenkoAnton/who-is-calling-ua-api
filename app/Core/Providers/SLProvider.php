<?php

declare(strict_types=1);

namespace App\Core\Providers;

use App\Core\ProviderEnum;

class SLProvider extends AbstractProvider implements ProviderInterface
{
    public static function getEnum(): ProviderEnum
    {
        return ProviderEnum::SL;
    }
}
