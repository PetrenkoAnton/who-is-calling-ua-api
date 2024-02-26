<?php

declare(strict_types=1);

namespace App\Core\Formatters\UrlFormatters;

interface UrlFormatterInterface
{
    public function format(string $phone): string;
}
