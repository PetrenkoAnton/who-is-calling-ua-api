<?php

declare(strict_types=1);

namespace App\Core\Parsers;

use App\Core\Collection;
use App\Core\ProviderEnum;

class ParserCollection extends Collection
{
    protected array $items;

    public function __construct(ParserInterface ...$items)
    {
        $this->items = $items;
    }

    public function getFirstFor(ProviderEnum $enum): ParserInterface
    {
        return $this->filter(static function (ParserInterface $parser) use ($enum) {
            return $parser->is($enum);
        })->first();
    }
}
