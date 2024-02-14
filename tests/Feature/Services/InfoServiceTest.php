<?php

declare(strict_types=1);

namespace Tests\Feature\Services;

use App\Core\Services\InfoService;
use App\Exceptions\Internal\InternalException;
use Tests\Support\VersionRenameHelper;
use Tests\TestCase;

use function config;
use function env;
use function file_get_contents;
use function realpath;
use function sort;
use function trim;

class InfoServiceTest extends TestCase
{
    private InfoService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = $this->app->make(InfoService::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        VersionRenameHelper::rollback();
    }

    /**
     * @group ok
     */
    public function testInfoSuccess(): void
    {
        // TODO! Change to the "@phpstan-ignore argument.type" after phpstan 1.11 will be released
        // @phpstan-ignore-next-line
        $expectedVersion = trim(file_get_contents(realpath(__DIR__ . '/../../../VERSION')));

        $expectedSupportedCodes = config('pn.supported_codes');
        sort($expectedSupportedCodes);

        $info = $this->service->getInfo();

        $this->assertIsArray($info);
        $this->assertArrayHasKey('version', $info);
        $this->assertArrayHasKey('providers', $info);
        $this->assertArrayHasKey('supported_codes', $info);

        $this->assertCount(3, $info);

        $this->assertEquals($expectedVersion, $info['version']);
        $this->assertEquals($expectedSupportedCodes, $info['supported_codes']);

        $this->assertCount(6, $info['providers']);

        $this->assertTrue((bool) env('KZ_PROVIDER'));
        $this->assertTrue((bool) env('TD_PROVIDER'));
        $this->assertTrue((bool) env('CI_PROVIDER'));
        $this->assertTrue((bool) env('SL_PROVIDER'));
        $this->assertTrue((bool) env('KC_PROVIDER'));
        $this->assertTrue((bool) env('CF_PROVIDER'));

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

    /**
     * @group +
     */
    public function testInfoThrowsException(): void
    {
        VersionRenameHelper::rename();

        $this->expectException(InternalException::class);
        $this->expectExceptionMessage('VERSION file not found');

        $this->service->getInfo();
    }
}
