<?php

declare(strict_types=1);

namespace App\Core\Formatters\UrlFormatters;

use App\Core\Collection;
use App\Core\ProviderEnum;

class UrlFormatterCollection extends Collection
{
    protected array $items;

    public function __construct(UrlFormatterInterface ...$items)
    {
        $this->items = $items;
    }

    public function getFirstFor(ProviderEnum $enum): UrlFormatterInterface
    {
        return $this->filter(static function (UrlFormatterInterface $formatter) use ($enum) {
            return $formatter->is($enum);
        })->first();
    }
}
