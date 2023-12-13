<?php

declare(strict_types=1);

namespace App\Helpers;

interface UrlFormatterInterface
{
    public function format(string $phone): string;
}
