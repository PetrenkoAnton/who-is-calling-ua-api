<?php

declare(strict_types=1);

namespace App\Core\Dto\Response\CommentsDetailedDto;

class ProviderDtoCollectionFactory
{
    public function create(): ProviderDtoCollection
    {
        return new ProviderDtoCollection();
    }
}
