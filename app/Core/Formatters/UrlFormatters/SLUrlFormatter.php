<?php

declare(strict_types=1);

namespace App\Core\Formatters\UrlFormatters;

class SLUrlFormatter implements UrlFormatterInterface
{
    public function format(string $phone): string
    {
        return 'https://slick.ly/ua/0' . $phone;
    }
}
