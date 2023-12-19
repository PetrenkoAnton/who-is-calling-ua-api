<?php

declare(strict_types=1);

namespace App\Core\Formatters\UrlFormatters;

use App\Core\ProviderEnum;

class SLUrlFormatter implements UrlFormatterInterface
{
    public function format(string $phone): string
    {
        return 'https://slick.ly/ua/0' . $phone;
    }

    public function is(ProviderEnum $provider): bool
    {
        return $provider === ProviderEnum::SL;
    }
}
