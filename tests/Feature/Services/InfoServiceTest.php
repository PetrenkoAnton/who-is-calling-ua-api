<?php

declare(strict_types=1);

namespace Tests\Feature\Services;

use App\Core\Services\InfoService;
use Tests\TestCase;

class InfoServiceTest  extends TestCase
{
    /**
     * @group ok
     */
    public function testInfo(): void
    {
        $service = $this->app->make(InfoService::class);

        // TODO! Change to the "@phpstan-ignore argument.type" after phpstan 1.11 will be released
        // @phpstan-ignore-next-line
        $expectedVersion = \trim(\file_get_contents(\realpath(__DIR__.'/../../../VERSION')));

        $expectedSupportedCodes = \config('pn.supported_codes');
        \sort($expectedSupportedCodes);

        $info = $service->getInfo();

        $this->assertIsArray($info);
        $this->assertArrayHasKey('version', $info);
        $this->assertArrayHasKey('providers', $info);
        $this->assertArrayHasKey('supported_codes', $info);

        $this->assertCount(3, $info);

        $this->assertEquals($expectedVersion, $info['version']);
        $this->assertEquals($expectedSupportedCodes, $info['supported_codes']);

        $this->assertCount(6, $info['providers']);

        $this->assertTrue((bool)\env('KZ_PROVIDER'));
        $this->assertTrue((bool)\env('TD_PROVIDER'));
        $this->assertTrue((bool)\env('CI_PROVIDER'));
        $this->assertTrue((bool)\env('SL_PROVIDER'));
        $this->assertTrue((bool)\env('KC_PROVIDER'));
        $this->assertTrue((bool)\env('CF_PROVIDER'));

        $expectedProviders = [
            'callfilter.app',
            'callinsider.com.ua',
            'kto-zvonil.com.ua',
            'ktozvonil.net',
            'slick.ly',
            'telefonnyjdovidnyk.com.ua',
        ];

        $this->assertEquals($expectedProviders, $info['providers']);
    }
}
