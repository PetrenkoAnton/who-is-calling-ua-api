<?php

declare(strict_types=1);

namespace Tests\Unit\Dto\Response;

use App\Core\Dto\Response\CommentsDetailedDto;
use App\Core\Dto\Response\CommentsDetailedDto\ProviderDto;
use App\Core\Dto\Response\CommentsDetailedDto\ProviderDtoCollection;
use App\Core\Dto\Response\CommentsDetailedDtoFactory;
use PHPUnit\Framework\TestCase;

class CommentsDetailedDtoFactoryTest extends TestCase
{
    private CommentsDetailedDtoFactory $dtoFactory;

    public function setUp(): void
    {
        $this->dtoFactory = new CommentsDetailedDtoFactory();
    }

    /**
     * @group ok
     */
    public function testCreate(): void
    {
        $data = [
            // @codingStandardsIgnoreStart
            'pn' => '044 355-15-91',
            'comments' => [
                'Надоели. Призы выигрывать. С разных номеров звонят.. и рядом ещё АК этелеграмм пытаются взломать. Ставьте двойную защиту.',
                'ушасили',
                'Робот-шахрай спокушає призом',
                'мне тільки що дзвонили ЗАРАРИ сдохніть',
                'виграв приз 380 тис надо пройти авторизацію говорила дівчина робот (програвалася запис / робот)',
                '(програвалася запис / робот)',
                'програвався запис (програвалася запис / робот)',
                'так само телефонував робот , казав про виграшний приз . Шахраї (програвалася запис / робот)',
                'Говорив молодий чоловік, стандартні фрази - комп\'ютер вибрав ваш номер, ви виграли 400 тис., давайте пройдемо авторизацію і т.ж. Однозначно шахраї. (програвалася запис / робот)',
                'Звонять і кажуть що номер є виграшним. Щоб получити приз, потрібно дати всю інформацію про себе. МОШШОНИКИ (програвалася запис / робот)'
            ],
            'providers' => [
                [
                    'name' => 'telefonnyjdovidnyk.com.ua',
                    'url' => 'https://www.telefonnyjdovidnyk.com.ua/nomer/0443551591',
                    'code' => 'TD',
                    'comments' => [
                        'Надоели. Призы выигрывать. С разных номеров звонят.. и рядом ещё АК этелеграмм пытаются взломать. Ставьте двойную защиту.',
                        'ушасили',
                        'Робот-шахрай спокушає призом'
                    ],
                    'error' => null
                ],
                [
                    'name' => 'ktozvonil.net',
                    'url' => 'https://ktozvonil.net/nomer/0443551591',
                    'code' => 'KZ',
                    'comments' => [],
                    'error' => null
                ],
                [
                    'name' => 'callinsider.com.ua',
                    'url' => 'https://www.callinsider.com.ua/ua/0443551591',
                    'code' => 'CI',
                    'comments' => [
                        'Надоели. Призы выигрывать. С разных номеров звонят.. и рядом ещё АК этелеграмм пытаются взломать. Ставьте двойную защиту.',
                        'ушасили',
                        'Робот-шахрай спокушає призом',
                        'мне тільки що дзвонили ЗАРАРИ сдохніть'
                    ],
                    'error' => null
                ],
                [
                    'name' => 'slick.ly',
                    'url' => 'https://slick.ly/ua/0443551591',
                    'code' => 'SL',
                    'comments' => [],
                    'error' => [
                        'message' => 'Client error: `GET https://slick.ly/ua/0443551591` resulted in a `403 Forbidden` response: error code: 1006',
                        'code' => 403
                    ]
                ],
                [
                    'name' => 'kto-zvonil.com.ua',
                    'url' => 'http://kto-zvonil.com.ua/number/044/3551591',
                    'code' => 'KC',
                    'comments' => [],
                    'error' => null
                ],
                [
                    'name' => 'callfilter.app',
                    'url' => 'https://callfilter.app/380443551591',
                    'code' => 'CF',
                    'comments' => [
                        'виграв приз 380 тис надо пройти авторизацію говорила дівчина робот (програвалася запис / робот)',
                        '(програвалася запис / робот)',
                        '(програвалася запис / робот)',
                        'програвався запис (програвалася запис / робот)',
                        'так само телефонував робот , казав про виграшний приз . Шахраї (програвалася запис / робот)',
                        'Говорив молодий чоловік, стандартні фрази - комп\'ютер вибрав ваш номер, ви виграли 400 тис., давайте пройдемо авторизацію і т.ж. Однозначно шахраї. (програвалася запис / робот)',
                        'Звонять і кажуть що номер є виграшним. Щоб получити приз, потрібно дати всю інформацію про себе. МОШШОНИКИ (програвалася запис / робот)'
                    ],
                    'error' => null
                ]
            ]
            // @codingStandardsIgnoreEnd
        ];

        $dto = $this->dtoFactory->create($data);

        $this->assertInstanceOf(CommentsDetailedDto::class, $dto);

        $this->assertEquals($data['pn'], $dto->getPn());
        $this->assertEquals($data['comments'], $dto->getComments());
        $this->assertInstanceOf(ProviderDtoCollection::class, $dto->getProviders());
        $this->assertCount(6, $dto->getProviders());

        /** @var ProviderDto $providerDto */
        $providerDto = $dto->getProviders()->getItem(0);
        $this->assertEquals($data['providers'][0]['name'], $providerDto->getName());
        $this->assertEquals($data['providers'][0]['url'], $providerDto->getUrl());
        $this->assertEquals($data['providers'][0]['code'], $providerDto->getCode());
        $this->assertEquals($data['providers'][0]['comments'], $providerDto->getComments());
        $this->assertCount(3, $providerDto->getComments());
        $this->assertEquals($data['providers'][0]['error'], $providerDto->getError());
        $this->assertNull($providerDto->getError());

        /** @var ProviderDto $providerDto */
        $providerDto = $dto->getProviders()->getItem(3);
        $error = $data['providers'][3]['error'];
        $this->assertEquals($error['message'], $providerDto->getError()->getMessage());
        $this->assertEquals($error['code'], $providerDto->getError()->getCode());
    }
}
