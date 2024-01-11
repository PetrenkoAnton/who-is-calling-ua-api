<?php

declare(strict_types=1);

namespace App\Core\Formatters\UrlFormatters;

use App\Core\ProviderEnum;
use Collection\Collectable;

interface UrlFormatterInterface extends Collectable
{
    public function format(string $phone): string;

    public function for(ProviderEnum $provider): bool;
}
