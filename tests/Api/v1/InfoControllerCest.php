<?php

declare(strict_types=1);

namespace Tests\Api\v1;

use Codeception\Util\HttpCode;
use Tests\Support\ApiTester;

class InfoControllerCest
{
    /**
     * @param ApiTester $I
     * @group smoke
     */
    public function getInfo(ApiTester $I): void
    {
        $I->sendGet('/v1/info');
        $I->seeResponseCodeIs(200);
        $I->seeResponseMatchesJsonType([
            'version' => 'string',
            'providers' => 'array',
            'supported_codes' => 'array',
        ]);
        $I->seeResponseContainsJson([
            'version' => '1.0.0',
            'providers' => [
                'callfilter.app',
                'callinsider.com.ua',
                'kto-zvonil.com.ua',
                'ktozvonil.net',
                'slick.ly',
                'telefonnyjdovidnyk.com.ua',
            ],
            'supported_codes' => [
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
        ]);
    }
}
