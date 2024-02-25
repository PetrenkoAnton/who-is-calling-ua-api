<?php

declare(strict_types=1);

namespace Tests\Unit\Dto\Response\CommentsDetailedDto;

use App\Core\Dto\Response\CommentsDetailedDto\ProviderDtoCollection;
use App\Core\Dto\Response\CommentsDetailedDto\ProviderDtoCollectionFactory;
use PHPUnit\Framework\TestCase;

class ProviderDtoCollectionFactoryTest extends TestCase
{
    private ProviderDtoCollectionFactory $dtoCollectionFactory;

    public function setUp(): void
    {
        $this->dtoCollectionFactory = new ProviderDtoCollectionFactory();
    }

    /**
     * @group ok
     */
    public function testCreate(): void
    {
        $this->assertInstanceOf(ProviderDtoCollection::class, $this->dtoCollectionFactory->create());
    }
}
