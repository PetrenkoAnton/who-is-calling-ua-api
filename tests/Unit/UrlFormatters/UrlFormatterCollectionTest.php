<?php

declare(strict_types=1);

namespace Tests\Unit\UrlFormatters;

use App\Core\Formatters\UrlFormatters\CFUrlFormatter;
use App\Core\Formatters\UrlFormatters\CIUrlFormatter;
use App\Core\Formatters\UrlFormatters\KCUrlFormatter;
use App\Core\Formatters\UrlFormatters\KZUrlFormatter;
use App\Core\Formatters\UrlFormatters\SLUrlFormatter;
use App\Core\Formatters\UrlFormatters\TDUrlFormatter;
use App\Core\Formatters\UrlFormatters\UrlFormatterCollection;
use App\Core\ProviderEnum;
use PHPUnit\Framework\TestCase;

class UrlFormatterCollectionTest extends TestCase
{
    private readonly UrlFormatterCollection $collection;

    public function setUp(): void
    {
        $this->collection = new UrlFormatterCollection(
            new CFUrlFormatter(),
            new CIUrlFormatter(),
            new KCUrlFormatter(),
            new KZUrlFormatter(),
            new SLUrlFormatter(),
            new TDUrlFormatter(),
        );
    }

    /**
     * @group ok
     * @dataProvider dp
     */
    public function testGetFirstFor(string $expected, ProviderEnum $enum)
    {
        $this->assertEquals($expected, get_class($this->collection->getFirstFor($enum)));
    }

    public static function dp(): array
    {
        return [
            [
                CFUrlFormatter::class,
                ProviderEnum::CF,
            ],
            [
                CIUrlFormatter::class,
                ProviderEnum::CI,
            ],
            [
                KCUrlFormatter::class,
                ProviderEnum::KC,
            ],
            [
                KZUrlFormatter::class,
                ProviderEnum::KZ,
            ],
            [
                SLUrlFormatter::class,
                ProviderEnum::SL,
            ],
            [
                TDUrlFormatter::class,
                ProviderEnum::TD,
            ],
        ];
    }
}
