<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\Dto\InfoDto;
use App\Core\Dto\InfoDtoFactory;
use PHPUnit\Framework\TestCase;

class InfoDtoFactoryTest extends TestCase
{
    private InfoDtoFactory $dtoFactory;

    public function setUp(): void
    {
        $this->dtoFactory = new InfoDtoFactory();
    }

    /**
     * @group ok
     */
    public function testCreate(): void
    {
        $data = [
            'version' => '1.0.0',
            'providers' => [
                'callfilter.app',
                'callinsider.com.ua',
                'kto-zvonil.com.ua',
                'ktozvonil.net',
                'slick.ly',
                'telefonnyjdovidnyk.com.ua',
            ],
            'supportedCodes' => [
                44,
                50,
                63,
                66,
                67,
                68,
                73,
                93,
                95,
                96,
                97,
                98,
                99,
            ],
        ];

        $dto = $this->dtoFactory->create($data);

        $this->assertInstanceOf(InfoDto::class, $dto);

        $this->assertEquals($data['version'], $dto->getVersion());
        $this->assertEquals($data['providers'], $dto->getProviders());
        $this->assertEquals($data['supportedCodes'], $dto->getSupportedCodes());
    }
}
