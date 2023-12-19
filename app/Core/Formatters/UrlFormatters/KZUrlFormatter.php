<?php

declare(strict_types=1);

namespace App\Core\Formatters\UrlFormatters;

use App\Core\ProviderEnum;

class KZUrlFormatter implements UrlFormatterInterface
{
    public function format(string $phone): string
    {
        return 'https://ktozvonil.net/nomer/0' . $phone;
    }

    public function for(ProviderEnum $provider): bool
    {
        return $provider === ProviderEnum::KZ;
    }
}
