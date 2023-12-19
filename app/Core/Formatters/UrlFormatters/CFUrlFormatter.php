<?php

declare(strict_types=1);

namespace App\Core\Formatters\UrlFormatters;

use App\Core\ProviderEnum;

class CFUrlFormatter implements UrlFormatterInterface
{
    public function format(string $phone): string
    {
        return 'https://callfilter.app/380' . $phone;
    }

    public function for(ProviderEnum $provider): bool
    {
        return $provider === ProviderEnum::CF;
    }
}
