<?php

declare(strict_types=1);

namespace Tests\Feature\Providers;

use App\Core\Providers\ProviderCollection;
use Tests\TestCase;

class ProviderCollectionTest extends TestCase
{
    public function tearDown(): void
    {
        putenv('CF_PROVIDER=1');
        putenv('CI_PROVIDER=1');
        putenv('KC_PROVIDER=1');
        putenv('KZ_PROVIDER=1');
        putenv('SL_PROVIDER=1');
        putenv('TD_PROVIDER=1');

        parent::tearDown();
    }

    /**
     * @group ok
     * @dataProvider dp
     */
    public function testGetEnabled(array $disabledProviders, int $expectedCount): void
    {
        foreach ($disabledProviders as $disabledProvider) {
            putenv($disabledProvider . '=0');
        }

        $collection = $this->app->make(ProviderCollection::class);

        $this->assertCount(6, $collection);
        $this->assertCount($expectedCount, $collection->getEnabled());
    }

    public static function dp(): array
    {
        return [
            [
                [
                    'CF_PROVIDER',
                ],
                5,
            ],
            [
                [
                    'CF_PROVIDER',
                    'CI_PROVIDER',
                    'KC_PROVIDER',
                ],
                3,
            ],
            [
                [
                    'CF_PROVIDER',
                    'CI_PROVIDER',
                    'KC_PROVIDER',
                    'KZ_PROVIDER',
                    'SL_PROVIDER',
                    'TD_PROVIDER',
                ],
                0,
            ],
        ];
    }
}
