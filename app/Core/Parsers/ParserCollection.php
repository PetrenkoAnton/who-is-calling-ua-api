<?php

declare(strict_types=1);

namespace App\Core\Parsers;

use App\Core\ProviderEnum;
use Collection\Collection;
use Collection\Collectable;
use Collection\Exception\CollectionException\InvalidKeyException;

class ParserCollection extends Collection
{
    public function __construct(ParserInterface ...$items)
    {
        parent::__construct(...$items);
    }

    /**
     * @throws InvalidKeyException
     */
    public function getFirstFor(ProviderEnum $enum): ParserInterface
    {
        return $this->filter(fn (ParserInterface $parser) => $parser->for($enum))->first();
    }
}
