<?php

declare(strict_types=1);

namespace App\Core\Formatters\UrlFormatters;

use App\Core\ProviderEnum;

class TDUrlFormatter implements UrlFormatterInterface
{
    public function format(string $phone): string
    {
        return 'https://www.telefonnyjdovidnyk.com.ua/nomer/0' . $phone;
    }

    public function is(ProviderEnum $provider): bool
    {
        return $provider === ProviderEnum::TD;
    }
}
