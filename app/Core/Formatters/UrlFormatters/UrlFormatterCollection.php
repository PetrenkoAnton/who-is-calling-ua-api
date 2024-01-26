<?php

declare(strict_types=1);

namespace App\Core\Formatters\UrlFormatters;

use App\Core\ProviderEnum;
use Collection\Collectable;
use Collection\Collection;

class UrlFormatterCollection extends Collection
{
    protected array $items;

    public function __construct(UrlFormatterInterface ...$items)
    {
        parent::__construct(...$items);
    }

    public function getFirstFor(ProviderEnum $enum): UrlFormatterInterface
    {
        // TODO! Change to the "@phpstan-ignore return.type" after phpstan 1.11 will be released
        // @phpstan-ignore-next-line
        return $this->filter(fn (UrlFormatterInterface $formatter) => $formatter->for($enum))->first();
    }
}
