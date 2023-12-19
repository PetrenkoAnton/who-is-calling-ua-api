<?php

declare(strict_types=1);

namespace App\Core\Formatters\UrlFormatters;

use App\Core\ProviderEnum;

class CIUrlFormatter implements UrlFormatterInterface
{
    public function format(string $phone): string
    {
        return 'https://www.callinsider.com.ua/ua/0' . $phone;
    }

    public function for(ProviderEnum $provider): bool
    {
        return $provider === ProviderEnum::CI;
    }
}
