<?php

declare(strict_types=1);

namespace App\Core\Providers;

class CFProvider extends AbstractProvider implements ProviderInterface
{
    public const NAME = 'callfilter.app';
    public const CODE = 'CF';
}
