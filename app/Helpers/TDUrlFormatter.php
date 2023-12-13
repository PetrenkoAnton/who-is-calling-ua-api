<?php

declare(strict_types=1);

namespace App\Helpers;

class TDUrlFormatter implements UrlFormatterInterface
{
    public function format(string $phone): string
    {
        return 'https://www.telefonnyjdovidnyk.com.ua/nomer/' . $phone;
    }
}
