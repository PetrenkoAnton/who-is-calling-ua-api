<?php

declare(strict_types=1);

namespace App\Helpers\UrlFormatter;

interface UrlFormatterInterface
{
    public function format(string $phone): string;
}
