<?php

declare(strict_types=1);

namespace App\Core\Formatters\UrlFormatters;

class TDUrlFormatter implements UrlFormatterInterface
{
    public function format(string $phone): string
    {
        return 'https://www.telefonnyjdovidnyk.com.ua/nomer/0' . $phone;
    }
}
