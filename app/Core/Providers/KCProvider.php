<?php

declare(strict_types=1);

namespace App\Core\Providers;

use App\Core\ProviderEnum;

class KCProvider extends AbstractProvider implements ProviderInterface
{
    public const ENUM = ProviderEnum::KC;

    public function getEnum(): ProviderEnum
    {
        return self::ENUM;
    }
}
