<?php

declare(strict_types=1);

namespace App\Core\Formatters\UrlFormatters;

class CFUrlFormatter implements UrlFormatterInterface
{
    public function format(string $phone): string
    {
        return 'https://callfilter.app/380' . $phone;
    }
}
