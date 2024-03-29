<?php

declare(strict_types=1);

namespace Tests\Feature\Services;

use App\Core\Collections\CommentsCollection;
use App\Core\Dto\Response\CommentsDetailedDto\ProviderDtoCollectionFactory;
use App\Core\Dto\Response\CommentsDetailedDto\ProviderDtoFactory;
use App\Core\Dto\Response\CommentsDetailedDtoFactory;
use App\Core\Dto\Response\CommentsDtoFactory;
use App\Core\Formatters\OutputPNFormatter;
use App\Core\ProviderEnum;
use App\Core\Providers\CFProvider;
use App\Core\Providers\CIProvider;
use App\Core\Providers\KCProvider;
use App\Core\Providers\KZProvider;
use App\Core\Providers\ProviderCollection;
use App\Core\Providers\SLProvider;
use App\Core\Providers\TDProvider;
use App\Core\Services\CommentService;
use Exception;
use Tests\TestCase;

class CommentServiceTest extends TestCase
{
    private string $pn;
    private CommentService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->pn = '443551591';

        $commentsCF = [
            // @codingStandardsIgnoreStart
            'виграв приз 380 тис надо пройти авторизацію говорила дівчина робот (програвалася запис / робот)',
            '(програвалася запис / робот)',
            '(програвалася запис / робот)',
            'програвався запис (програвалася запис / робот)',
            'так само телефонував робот , казав про виграшний приз . Шахраї (програвалася запис / робот)',
            'Говорив молодий чоловік, стандартні фрази - комп\'ютер вибрав ваш номер, ви виграли 400 тис., давайте пройдемо авторизацію і т.ж. Однозначно шахраї. (програвалася запис / робот)',
            'Звонять і кажуть що номер є виграшним. Щоб получити приз, потрібно дати всю інформацію про себе. МОШШОНИКИ (програвалася запис / робот)',
            // @codingStandardsIgnoreEnd
        ];

        $commentsTD = [
            // @codingStandardsIgnoreStart
            'Надоели. Призы выигрывать. С разных номеров звонят.. и рядом ещё АК этелеграмм пытаются взломать. Ставьте двойную защиту.',
            'ушасили',
            'Робот-шахрай спокушає призом',
            // @codingStandardsIgnoreEnd
        ];

        $providerCF = $this->createConfiguredMock(CFProvider::class, [
            'getComments' => $commentsCF,
            'enable' => true,
            'getEnum' => ProviderEnum::CF,
        ]);

        $providerCI = $this->createConfiguredMock(CIProvider::class, [
            'getComments' => [],
            'enable' => true,
            'getEnum' => ProviderEnum::CI,
        ]);

        $providerKC = $this->createConfiguredMock(KCProvider::class, [
            'getComments' => [],
            'enable' => true,
            'getEnum' => ProviderEnum::KC,
        ]);

        $providerKZ = $this->createConfiguredMock(KZProvider::class, [
            'getComments' => [],
            'enable' => false,
            'getEnum' => ProviderEnum::KZ,
        ]);

        $exception = new Exception(
        // @codingStandardsIgnoreStart
            message: "Client error: `GET https://slick.ly/ua/0443551591` resulted in a `403 Forbidden` response:\nerror code: 1006\n",
            // @codingStandardsIgnoreEnd
            code: 403,
        );

        $providerSL = $this->createConfiguredMock(SLProvider::class, [
            'enable' => true,
            'getEnum' => ProviderEnum::SL,
        ]);

        $providerSL
            ->method('getComments')
            ->willThrowException($exception);

        $providerTD = $this->createConfiguredMock(TDProvider::class, [
            'getComments' => $commentsTD,
            'enable' => true,
            'getEnum' => ProviderEnum::TD,
        ]);

        $providerCollection = new ProviderCollection(
            $providerCF,
            $providerCI,
            $providerKC,
            $providerKZ,
            $providerSL,
            $providerTD,
        );

        $this->service = new CommentService(
            $providerCollection,
            $this->app->make(OutputPNFormatter::class),
            $this->app->make(CommentsCollection::class),
            $this->app->make(CommentsDtoFactory::class),
            $this->app->make(CommentsDetailedDtoFactory::class),
            $this->app->make(ProviderDtoCollectionFactory::class),
            $this->app->make(ProviderDtoFactory::class),
        );
    }

    /**
     * @group ok
     * @dataProvider dpSearch
     */
    public function testSearch(bool $useCache): void
    {
        $actual = $this->service->search($this->pn, $useCache);

        $expected = [
            // @codingStandardsIgnoreStart
            'pn' => '044 355-15-91',
            'cache' => $useCache,
            'comments' =>
                array(
                    0 => 'виграв приз 380 тис надо пройти авторизацію говорила дівчина робот (програвалася запис / робот)',
                    1 => '(програвалася запис / робот)',
                    2 => 'програвався запис (програвалася запис / робот)',
                    3 => 'так само телефонував робот , казав про виграшний приз . Шахраї (програвалася запис / робот)',
                    4 => 'Говорив молодий чоловік, стандартні фрази - комп\'ютер вибрав ваш номер, ви виграли 400 тис., давайте пройдемо авторизацію і т.ж. Однозначно шахраї. (програвалася запис / робот)',
                    5 => 'Звонять і кажуть що номер є виграшним. Щоб получити приз, потрібно дати всю інформацію про себе. МОШШОНИКИ (програвалася запис / робот)',
                    6 => 'Надоели. Призы выигрывать. С разных номеров звонят.. и рядом ещё АК этелеграмм пытаются взломать. Ставьте двойную защиту.',
                    7 => 'ушасили',
                    8 => 'Робот-шахрай спокушає призом',
                ),
            // @codingStandardsIgnoreEnd
        ];

        $this->assertEquals($expected, $actual->toArray());
    }

    public static function dpSearch(): array
    {
        return [
            [false],
            [true],
        ];
    }

    /**
     * @group ok
     */
    public function testDetailedSearch(): void
    {
        $actual = $this->service->detailedSearch($this->pn);

        $expected = [
            // @codingStandardsIgnoreStart
            'pn' => '044 355-15-91',
            'comments' =>
                array (
                    0 => 'виграв приз 380 тис надо пройти авторизацію говорила дівчина робот (програвалася запис / робот)',
                    1 => '(програвалася запис / робот)',
                    2 => 'програвався запис (програвалася запис / робот)',
                    3 => 'так само телефонував робот , казав про виграшний приз . Шахраї (програвалася запис / робот)',
                    4 => 'Говорив молодий чоловік, стандартні фрази - комп\'ютер вибрав ваш номер, ви виграли 400 тис., давайте пройдемо авторизацію і т.ж. Однозначно шахраї. (програвалася запис / робот)',
                    5 => 'Звонять і кажуть що номер є виграшним. Щоб получити приз, потрібно дати всю інформацію про себе. МОШШОНИКИ (програвалася запис / робот)',
                    6 => 'Надоели. Призы выигрывать. С разных номеров звонят.. и рядом ещё АК этелеграмм пытаются взломать. Ставьте двойную защиту.',
                    7 => 'ушасили',
                    8 => 'Робот-шахрай спокушає призом',
                ),
            'providers' =>
                array (
                    0 =>
                        array (
                            'name' => 'callfilter.app',
                            'url' => '',
                            'code' => 'CF',
                            'comments' =>
                                array (
                                    0 => 'виграв приз 380 тис надо пройти авторизацію говорила дівчина робот (програвалася запис / робот)',
                                    1 => '(програвалася запис / робот)',
                                    2 => '(програвалася запис / робот)',
                                    3 => 'програвався запис (програвалася запис / робот)',
                                    4 => 'так само телефонував робот , казав про виграшний приз . Шахраї (програвалася запис / робот)',
                                    5 => 'Говорив молодий чоловік, стандартні фрази - комп\'ютер вибрав ваш номер, ви виграли 400 тис., давайте пройдемо авторизацію і т.ж. Однозначно шахраї. (програвалася запис / робот)',
                                    6 => 'Звонять і кажуть що номер є виграшним. Щоб получити приз, потрібно дати всю інформацію про себе. МОШШОНИКИ (програвалася запис / робот)',
                                ),
                            'error' => NULL,
                        ),
                    1 =>
                        array (
                            'name' => 'callinsider.com.ua',
                            'url' => '',
                            'code' => 'CI',
                            'comments' =>
                                array (
                                ),
                            'error' => NULL,
                        ),
                    2 =>
                        array (
                            'name' => 'kto-zvonil.com.ua',
                            'url' => '',
                            'code' => 'KC',
                            'comments' =>
                                array (
                                ),
                            'error' => NULL,
                        ),
                    3 =>
                        array (
                            'name' => 'slick.ly',
                            'url' => '',
                            'code' => 'SL',
                            'comments' =>
                                array (
                                ),
                            'error' =>
                                array (
                                    'message' => 'Client error: `GET https://slick.ly/ua/0443551591` resulted in a `403 Forbidden` response:
error code: 1006
',
                                    'code' => 403,
                                ),
                        ),
                    4 =>
                        array (
                            'name' => 'telefonnyjdovidnyk.com.ua',
                            'url' => '',
                            'code' => 'TD',
                            'comments' =>
                                array (
                                    0 => 'Надоели. Призы выигрывать. С разных номеров звонят.. и рядом ещё АК этелеграмм пытаются взломать. Ставьте двойную защиту.',
                                    1 => 'ушасили',
                                    2 => 'Робот-шахрай спокушає призом',
                                ),
                            'error' => NULL,
                        ),
                ),
            // @codingStandardsIgnoreEnd
        ];

        $this->assertEquals($expected, $actual->toArray());
    }
}
