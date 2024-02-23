<?php

declare(strict_types=1);

namespace Tests\Api\v1;

use Codeception\Example;
use Tests\Support\ApiTester;

use function sprintf;
use function substr;

class CommentControllerCest
{
    /**
     * @group smoke
     * @dataProvider dpGetSearchSuccess
     */
    public function getSearchSuccess(ApiTester $apiTester, Example $example): void
    {
        $apiTester->sendGet(sprintf('/v1/comments?pn=%s&c=%s', $example['pn'], (string) $example['c']));
        $apiTester->seeResponseCodeIs(200);
        $apiTester->seeResponseMatchesJsonType([
            'pn' => 'string',
            'cache' => 'boolean',
            'comments' => 'array',
        ]);
        $apiTester->seeResponseContainsJson([
            'pn' => $example['pnResponse'],
            'cache' => (bool) $example['c'],
        ]);
    }

    /**
     * @group smoke
     * @dataProvider dpValidationErrors
     */
    public function getSearchWithValidationError(ApiTester $apiTester, Example $example): void
    {
        $apiTester->sendGet(sprintf('/v1/comments?pn=%s&c=%s', $example['pn'], $example['c']));
        $apiTester->seeResponseCodeIs(422);
        $apiTester->seeResponseMatchesJsonType([
            'error' => [
                'validation' => [
                    [
                        'attribute' => 'string',
                        'info' => 'string',
                    ],
                ],
            ],
            'code' => 'integer',
        ]);
        $apiTester->seeResponseContainsJson([
            'error' => [
                'validation' => [
                    [
                        'attribute' => 'pn',
                        'info' => $example['error'],
                    ],
                ],
            ],
            'code' => 422,
        ]);
    }

    /**
     * @group smoke
     * @dataProvider dpGetSearchSuccess
     */
    public function getDetailedSearchSuccess(ApiTester $apiTester, Example $example): void
    {
        $apiTester->sendGet(sprintf('/v1/comments_detailed?pn=%s', $example['pn']));
        $apiTester->seeResponseCodeIs(200);
        $apiTester->seeResponseMatchesJsonType([
            'pn' => 'string',
            'comments' => 'array',
            'providers' => [
                [
                    'name' => 'string',
                    'url' => 'string',
                    'code' => 'string',
                    'comments' => 'array',
                    'error' => 'array|null',
                ],
            ],
        ]);
        $apiTester->seeResponseContainsJson([
            'pn' => $example['pnResponse'],
            'providers' => [
                [
                    'name' => 'telefonnyjdovidnyk.com.ua',
                    'url' => sprintf('https://www.telefonnyjdovidnyk.com.ua/nomer/0%s', $example['pn']),
                    'code' => 'TD',
                ],
                [
                    'name' => 'ktozvonil.net',
                    'url' => sprintf('https://ktozvonil.net/nomer/0%s', $example['pn']),
                    'code' => 'KZ',
                ],
                [
                    'name' => 'callinsider.com.ua',
                    'url' => sprintf('https://www.callinsider.com.ua/ua/0%s', $example['pn']),
                    'code' => 'CI',
                ],
                [
                    'name' => 'slick.ly',
                    'url' => sprintf('https://slick.ly/ua/0%s', $example['pn']),
                    'code' => 'SL',
                ],
                [
                    'name' => 'kto-zvonil.com.ua',
                    'url' => sprintf(
                        'http://kto-zvonil.com.ua/number/0%s/%s',
                        substr($example['pn'], 0, 2),
                        substr($example['pn'], 2, 7),
                    ),
                    'code' => 'KC',
                ],
                [
                    'name' => 'callfilter.app',
                    'url' => sprintf('https://callfilter.app/380%s', $example['pn']),
                    'code' => 'CF',
                ],
            ],
        ]);
    }

    public function dpGetSearchSuccess(): array
    {
        return [
            [
                'pn' => '680719969',
                'c' => 0,
                'pnResponse' => '068 071-99-69',
            ],
            [
                'pn' => '680719969',
                'c' => 1,
                'pnResponse' => '068 071-99-69',
            ],
        ];
    }

    /**
     * @group smoke
     * @dataProvider dpValidationErrors
     */
    public function getDetailedSearchWithValidationError(ApiTester $apiTester, Example $example): void
    {
        $apiTester->sendGet(sprintf('/v1/comments_detailed?pn=%s&c=%s', $example['pn'], $example['c']));
        $apiTester->seeResponseCodeIs(422);
        $apiTester->seeResponseMatchesJsonType([
            'error' => [
                'validation' => [
                    [
                        'attribute' => 'string',
                        'info' => 'string',
                    ],
                ],
            ],
            'code' => 'integer',
        ]);
        $apiTester->seeResponseContainsJson([
            'error' => [
                'validation' => [
                    [
                        'attribute' => 'pn',
                        'info' => $example['error'],
                    ],
                ],
            ],
            'code' => 422,
        ]);
    }

    public function dpValidationErrors(): array
    {
        return [
            [
                'pn' => '',
                'c' => 'aaa',
                'error' => 'The pn field is required.',
            ],
            [
                'pn' => 'a',
                'c' => 123,
                'error' => 'Not numeric phone number',
            ],
            [
                'pn' => '431231212',
                'c' => '[]',
                'error' => 'Unsupported operator code',
            ],
            [
                'pn' => '4433322113',
                'c' => 'null',
                'error' => 'Invalid phone number format',
            ],
        ];
    }
}
