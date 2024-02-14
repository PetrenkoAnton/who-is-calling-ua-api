<?php

declare(strict_types=1);

namespace App\Core\Providers;

use App\Core\ProviderEnum;

class CIProvider extends AbstractProvider implements ProviderInterface
{
    public const ENUM = ProviderEnum::CI;

    public function getEnum(): ProviderEnum
    {
        return self::ENUM;
    }
}
