<?php

declare(strict_types=1);

namespace Tests\Feature\Services;

use App\Core\Formatters\OutputPNFormatter;
use App\Core\ProviderEnum;
use App\Core\Providers\CFProvider;
use App\Core\Providers\CIProvider;
use App\Core\Providers\KCProvider;
use App\Core\Providers\KZProvider;
use App\Core\Providers\ProviderCollection;
use App\Core\Providers\SLProvider;
use App\Core\Providers\TDProvider;
use App\Core\Services\Internal\CommentsService;
use App\Core\Services\SearchService;
use Tests\TestCase;

class SearchServiceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @group ok
     */
    public function testSearch(): void
    {
        $pn = '443551591';

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

        $providerSL = $this->createConfiguredMock(SLProvider::class, [
            'getComments' => [],
            'enable' => false,
            'getEnum' => ProviderEnum::SL,
        ]);

        $providerTD = $this->createConfiguredMock(TDProvider::class, [
            'getComments' => $commentsTD,
            'enable' => true,
            'getEnum' => ProviderEnum::TD,
        ]);

        $providerCollection = new ProviderCollection(
            $providerCF, $providerCI, $providerKC, $providerKZ, $providerSL, $providerTD,
        );

        $service = new SearchService(
            $providerCollection,
            $this->app->make(OutputPNFormatter::class),
            $this->app->make(CommentsService::class),
        );

        $expected = array(
            // @codingStandardsIgnoreStart
            'pn' => '044 355-15-91',
            'cache' => false,
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
            'providers' =>
                array(
                    0 =>
                        array(
                            'name' => 'callfilter.app',
                            'url' => '',
                            'code' => 'CF',
                            'comments' =>
                                array(
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
                        array(
                            'name' => 'callinsider.com.ua',
                            'url' => '',
                            'code' => 'CI',
                            'comments' =>
                                array(),
                            'error' => NULL,
                        ),
                    2 =>
                        array(
                            'name' => 'kto-zvonil.com.ua',
                            'url' => '',
                            'code' => 'KC',
                            'comments' =>
                                array(),
                            'error' => NULL,
                        ),
                    3 =>
                        array(
                            'name' => 'telefonnyjdovidnyk.com.ua',
                            'url' => '',
                            'code' => 'TD',
                            'comments' =>
                                array(
                                    0 => 'Надоели. Призы выигрывать. С разных номеров звонят.. и рядом ещё АК этелеграмм пытаются взломать. Ставьте двойную защиту.',
                                    1 => 'ушасили',
                                    2 => 'Робот-шахрай спокушає призом',
                                ),
                            'error' => NULL,
                        ),
                ),
            // @codingStandardsIgnoreEnd
        );

        $actual = $service->search($pn, false);

        $this->assertEquals($expected, $actual);
    }
}
