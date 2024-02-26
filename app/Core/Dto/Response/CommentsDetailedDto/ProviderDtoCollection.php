<?php

declare(strict_types=1);

namespace App\Core\Dto\Response\CommentsDetailedDto;

use Dto\DtoCollection;

class ProviderDtoCollection extends DtoCollection
{
    public function __construct(ProviderDto ...$items)
    {
        parent::__construct(...$items);
    }
}
