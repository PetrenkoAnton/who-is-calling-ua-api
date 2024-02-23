<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\Formatters\UrlFormatters\CFUrlFormatter;
use App\Core\Formatters\UrlFormatters\CIUrlFormatter;
use App\Core\Formatters\UrlFormatters\KCUrlFormatter;
use App\Core\Formatters\UrlFormatters\KZUrlFormatter;
use App\Core\Formatters\UrlFormatters\SLUrlFormatter;
use App\Core\Formatters\UrlFormatters\TDUrlFormatter;
use App\Core\Formatters\UrlFormatters\UrlFormatterInterface;
use PHPUnit\Framework\TestCase;

class UrlFormattersTest extends TestCase
{
    /**
     * @group ok
     * @dataProvider dp
     */
    public function testFormat(UrlFormatterInterface $urlFormatter, string $expected): void
    {
        $this->assertEquals($expected, $urlFormatter->format('677654321'));
    }

    public static function dp(): array
    {
        return [
            [
                new CFUrlFormatter(),
                'https://callfilter.app/380677654321',
            ],
            [
                new CIUrlFormatter(),
                'https://www.callinsider.com.ua/ua/0677654321',
            ],
            [
                new KCUrlFormatter(),
                'http://kto-zvonil.com.ua/number/067/7654321',
            ],
            [
                new KZUrlFormatter(),
                'https://ktozvonil.net/nomer/0677654321',
            ],
            [
                new SLUrlFormatter(),
                'https://slick.ly/ua/0677654321',
            ],
            [
                new TDUrlFormatter(),
                'https://www.telefonnyjdovidnyk.com.ua/nomer/0677654321',
            ],
        ];
    }
}
