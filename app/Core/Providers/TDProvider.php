<?php

declare(strict_types=1);

namespace App\Core\Providers;

use App\Core\ProviderEnum;

class TDProvider extends AbstractProvider implements ProviderInterface
{
    public const ENUM = ProviderEnum::TD;

    public function getEnum(): ProviderEnum
    {
        return self::ENUM;
    }
}
