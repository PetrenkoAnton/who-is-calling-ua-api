<?php

declare(strict_types=1);

namespace App\Core\Providers;

use App\Core\ProviderEnum;

class CFProvider extends AbstractProvider implements ProviderInterface
{
    public const ENUM = ProviderEnum::CF;

    public function getEnum(): ProviderEnum
    {
        return self::ENUM;
    }
}
