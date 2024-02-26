<?php

declare(strict_types=1);

namespace App\Core\Providers;

use App\Core\ProviderEnum;

class SLProvider extends AbstractProvider implements ProviderInterface
{
    public const ENUM = ProviderEnum::SL;

    public function getEnum(): ProviderEnum
    {
        return self::ENUM;
    }
}
