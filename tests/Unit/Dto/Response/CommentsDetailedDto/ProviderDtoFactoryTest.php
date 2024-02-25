<?php

declare(strict_types=1);

namespace Tests\Unit\Dto\Response\CommentsDetailedDto;

use App\Core\Dto\Response\CommentsDetailedDto\ProviderDto;
use App\Core\Dto\Response\CommentsDetailedDto\ProviderDto\ErrorDto;
use App\Core\Dto\Response\CommentsDetailedDto\ProviderDtoFactory;
use PHPUnit\Framework\TestCase;

class ProviderDtoFactoryTest extends TestCase
{
    private ProviderDtoFactory $dtoFactory;

    public function setUp(): void
    {
        $this->dtoFactory = new ProviderDtoFactory();
    }

    /**
     * @group ok
     */
    public function testCreate(): void
    {
        $data = [
            // @codingStandardsIgnoreStart
            'name' => 'slick.ly',
            'url' => 'https://slick.ly/ua/0443551591',
            'code' => 'SL',
            'comments' => [],
            'error' => [
                'message' => 'Client error: `GET https://slick.ly/ua/0443551591` resulted in a `403 Forbidden` response: error code: 1006',
                'code' => 403
            ],
            // @codingStandardsIgnoreEnd
        ];

        $dto = $this->dtoFactory->create($data);

        $this->assertInstanceOf(ProviderDto::class, $dto);

        $this->assertEquals($data['name'], $dto->getName());
        $this->assertEquals($data['url'], $dto->getUrl());
        $this->assertEquals($data['code'], $dto->getCode());
        $this->assertEquals($data['comments'], $dto->getComments());
        $this->assertCount(0, $dto->getComments());
        $this->assertInstanceOf(ErrorDto::class, $dto->getError());
        $this->assertEquals($data['error']['message'], $dto->getError()->getMessage());
        $this->assertEquals($data['error']['code'], $dto->getError()->getCode());
    }
}
