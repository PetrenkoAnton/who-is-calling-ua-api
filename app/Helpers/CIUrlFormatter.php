<?php

declare(strict_types=1);

namespace App\Helpers;

class CIUrlFormatter implements UrlFormatterInterface
{
    public function format(string $phone): string
    {
        return 'https://www.callinsider.com.ua/ua/0' . $phone;
    }
}
